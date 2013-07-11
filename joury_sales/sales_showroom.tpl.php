<?php
// $Id$
$current_module_path = drupal_get_path('module' , 'joury_sales') ; 
$siteurl = url('', array('absolute' => TRUE)) ; 
$redirectpage = url('joury/bill/' , array('absolute' => TRUE)) ; 
drupal_add_js($current_module_path."/jquery-1.4.3.min.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_js($current_module_path."/js/jquery-ui-1.8.14.custom.min.js") ;
drupal_add_css($current_module_path."/smoothness/jquery-ui-1.8.14.custom.css") ;
drupal_add_css($current_module_path."/fancybox/jquery.fancybox-1.3.4.css") ;

$combox_box_module_path = drupal_get_path('module' , 'joury_register_service') ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcommon.js") ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcombo.js") ; 
drupal_add_css($combox_box_module_path."/codebase/dhtmlxcombo.css") ; 

drupal_add_css($current_module_path."/joury_sales.css") ;
drupal_add_js($current_module_path."/joury_sales.js") ;
drupal_add_js(array('url' => $siteurl) , 'setting'  ); 

if(!empty($_POST['sales-save']) && !empty($_POST['clientid']) && !empty($_POST['showroomid']) ){
global $user ; 	
$showroomid = 	$_POST['showroomid'] ; 
$clientid = 	$_POST['clientid'] ; 
$date = 	$_POST['dateee'] ; 
	foreach($_POST as $key => $val){
		if($val == 'on'){
			$pid = substr($key,7,30) ; 
			$productid_arr[] = $pid ; //array of products
			$quantity_arr[] = $_POST['quantity-'.$pid] ;  // array of quantities
			$sellprice_arr[] = $_POST['sellprice-'.$pid] ;  // array of sellprice
			$price_arr[] = $_POST['price-'.$pid] ;  // array of storeprice

		}			
	}	
	$number_of_update = count($productid_arr) ; 
	if($number_of_update !=0){
	for($m=0 ; $m<$number_of_update ; $m++ ){		
	//	db_query("update `joury_showroom` set `quantity` = `quantity` - %d where `showroomid` =  %d and `productid` = %d" ,$quantity[$m],$showroomid,$productid[$m] ) ; 
		$productid = $productid_arr[$m] ; 
		$productname =  _get_product_name($productid) ; 
		$sellprice = $sellprice_arr[$m] ; 
		$price = $price_arr[$m] ;  
		$quantity = $quantity_arr[$m] ;
		$total_price = $sellprice * $quantity ; 
		$totalprice = $total_price ; //duplicated
		$clientname = _get_client_name($clientid) ; 



		if(_check_product_in_client_bill($productid,$clientid)){
			if($quantity != 0){
			$result_handle =  db_query("select * from `joury_bill` where `productid` = %d and `clientid` = %d and `status` = 0" ,$productid , $clientid ) ;
			$result = db_fetch_object($result_handle) ; 
			$old_quantity  =  $result->quantity ; 	
			$old_price  =  $result->sellprice ;
			$old_total_price = $old_price*$old_quantity ; 
			$old_new_quantity =  $old_quantity + $quantity ; 
			$old_new_total_price =  $old_total_price 	+ $total_price ; 
			$old_new_unit_price = $old_new_total_price/$old_new_quantity ; 
			$total_price_new = $old_new_unit_price  *  $old_new_quantity  ; 
			if((is_float($old_new_quantity) || is_int($old_new_quantity)) && (is_float($old_new_unit_price) || is_int($old_new_unit_price)) && $old_new_quantity != 0 &&  $old_new_unit_price != 0 ){ 
				db_query("update `joury_bill` set `quantity` = %f , `sellprice` = %f,`totalprice` = %f where clientid=%d and productid=%d and `status` = 0",$old_new_quantity ,$old_new_unit_price,$total_price_new,$clientid,$productid )	 ; 		
				db_query("update `joury_showroom` set `quantity` = `quantity` - %f where `showroomid` = %d and `productid` = %d", $quantity,$showroomid,$productid ) ; 
				$quantity_in_showroom_now = db_query("select `quantity` from `joury_showroom` where `showroomid` = %d and `productid` = %d ",$showroomid, $productid ) ; 
				$quantity_in_showroom_now_obj = db_fetch_object($quantity_in_showroom_now) ; 
				$quantity_in_showroom_now = $quantity_in_showroom_now_obj->quantity ; 
				if($quantity_in_showroom_now == '0'){
					db_query("delete from `joury_showroom` where `showroomid` = %d and `productid` = %d " ,$showroomid,$productid) ; 
				}	
			}else {
				echo "<div class='message error' > Bad input..!! </div>" ; 	
			}
			}
		}else{
					if($quantity != 0){
					db_query("insert into `joury_bill` (`type`,`clientid`,`clientname`,`productid`,`productname`,`showroomid`,`quantity`,`sellprice`,`totalprice`,`date`,`status`,`price`,`by`) values ('%s',%d,'%s',%d,'%s',%d,%d,%f,%f,'%s',%d,%f,%d)",
					'product',$clientid,$clientname,$productid,$productname,$showroomid,$quantity,$sellprice,$totalprice,$date,0,$price,$user->uid) ; 		
					db_query("update `joury_showroom` set `quantity` = `quantity` - %f where `showroomid` = %d and `productid` = %d", $quantity,$showroomid,$productid ) ; 		
					$quantity_in_showroom_now = db_query("select `quantity` from `joury_showroom` where `showroomid` = %d and `productid` = %d ",$showroomid, $productid ) ; 
					$quantity_in_showroom_now_obj = db_fetch_object($quantity_in_showroom_now) ; 
					$quantity_in_showroom_now = $quantity_in_showroom_now_obj->quantity ; 
					if($quantity_in_showroom_now == '0'){
						db_query("delete from `joury_showroom` where `showroomid` = %d and `productid` = %d " ,$showroomid,$productid) ; 
					}	
					}			 		
			}













	}	
	drupal_set_message("<div class='message ok'><center>Successfully added</center></div>") ;
	//drupal_goto($redirectpage.$clientid) ; 
	}
}	

$staff_center = $user->centerdetails ; 
$m = 0 ; 
$showrooms = _get_all_showrooms() ; 
$number_of_showrooms =  count($showrooms) ; 
$ajax = url('ajax/sales/showroom/products/',array('absolute' => TRUE)) ;
echo "<table id='joury-showroom-showrooms' >" ;
for($k=0 ; $k < $number_of_showrooms ; $k++){
  if(user_access("override centers division")){	
  	$m++ ; 
		echo "<tr>" ; 
			echo "<td id='joury-showroom-showrooms-row'>" ;
				echo "<div  id='showroom-container' ><a href='$ajax".$showrooms[$k]->sid."' id='showroom' > ".$showrooms[$k]->name." </a></div>"  ;			
			echo "</td>";
		echo "<tr>" ;  
  }else{
	 if($staff_center == $showrooms[$k]->center){
	 	$m++ ; 
		echo "<tr>" ; 
			echo "<td id='joury-showroom-showrooms-row'>" ;
				echo "<div  id='showroom-container' ><a href='$ajax".$showrooms[$k]->sid."' id='showroom' > ".$showrooms[$k]->name." </a></div>"  ;			
			echo "</td>";
		echo "<tr>" ;  
	 }	
	}
	
		
}	
 
 echo "</table>" ;
 
if($m == 0) {
	drupal_set_message("<div class='message error'><center>NO SHOWROOMS AVAILABLE</center></div>") ;	
}	 
 
 
 