<?php
// $Id$

$current_module_path = drupal_get_path('module' , 'joury_sales') ; 
$siteurl = url('', array('absolute' => TRUE)) ; 
$redirectpage = url('joury/bill/' , array('absolute' => TRUE)) ; 
drupal_add_js($current_module_path."/jquery-1.4.3.min.js") ;
drupal_add_js($current_module_path."/js/jquery-ui-1.8.14.custom.min.js") ;
drupal_add_css($current_module_path."/smoothness/jquery-ui-1.8.14.custom.css") ;
drupal_add_css($current_module_path."/joury_sales.css") ;

$combox_box_module_path = drupal_get_path('module' , 'joury_register_service') ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcommon.js") ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcombo.js") ; 
drupal_add_css($combox_box_module_path."/codebase/dhtmlxcombo.css") ; 



drupal_add_js($current_module_path."/joury_returned_products.js") ;
drupal_add_js(array('url' => $siteurl) , 'setting'  ); 

if(!empty($_POST['return-submit']) && !empty($_POST['clientid']) && !empty($_POST['date']) ){
$clientid = 	$_POST['clientid'] ; 
$date = 	trim($_POST['date']) ; 

	foreach($_POST as $key => $val){
		if($val == 'on'){
			$pid = substr($key,7,30) ; 
			$productid_arr[] = $pid ; //array of products
			$quantity_arr[] = $_POST['quantity-'.$pid] ;  // array of quantities
			$showroomid_arr[] = $_POST['showroomid-'.$pid] ;  // array of showroomid
			$sellprice_arr[] = $_POST['sellprice-'.$pid] ;  // array of sellprice
			$price_arr[] = $_POST['price-'.$pid] ;  // array of price
			$exist_quantity_arr[] = $_POST['exist-quantity-'.$pid] ; 
			$status_arr[] = $_POST['status-'.$pid] ;  // array of status
		}			
	}	
	$number_of_update = count($productid_arr) ; 
	if($number_of_update !=0){
	for($m=0 ; $m<$number_of_update ; $m++ ){		
		$productid = $productid_arr[$m] ; 
		$sellprice = trim($sellprice_arr[$m]) ; 
		$price = $price_arr[$m] ;  
		$quantity = $quantity_arr[$m] ;
		$showroomid = $showroomid_arr[$m] ; 
		$status = $status_arr[$m] ;
		$existquantity = $exist_quantity_arr[$m] ;		
		$clientname = _get_client_name($clientid) ;
		$productname =  _get_product_name($productid) ; 
		$showroomname = _get_showroom_name_from_id($showroomid) ; 
		$total_price =  $price *  $quantity ; 
		$totalsellprice = $sellprice * $quantity ; 
		static $returnedmoney = 0 ; 
		

		if( $existquantity > $quantity ){
			
			db_query("update `joury_bill` set `quantity` = `quantity` - %d  where `productid` = %d and `clientid` = %d and `date` like '%%%s%%' and `price` = %d and `quantity` = %d  and `status` = %d limit 1",$quantity,$productid,$clientid,$date,$price,$existquantity,$status)	;
			
 		/*	db_query("update `joury_bill` set `quantity` = `quantity` - %d  where `clientid` = %d and `date` = '%s' and `productid` = %d
			and `sellprice` = %f and `status` = %d and `quantity` = %d",$quantity,$clientid,$date,$productid,$sellprice,1,$existquantity ) ;*/
			$returnedmoney +=  $totalsellprice ; 
		} 
		if( $existquantity == $quantity ){
			db_query("delete from  `joury_bill` where `clientid`=%d and `date` like '%%%s%%' and `productid` = %d and `status` = %d
			   limit 1",$clientid,$date,$productid,$status) ;
			$returnedmoney +=  $totalsellprice ;  
		}	
		
			if( $existquantity < $quantity ){
			drupal_set_message("<div class='message error'><center>ERROR NOT ALL OPERATIONS COMPLETED </center></div>") ; 
			continue ; 
			}









		// insert data to joury_showroom table
		
		if(_check_product_in_showroom($productid,$showroomid)){
			$result_handle =  db_query("select * from `joury_showroom` where `productid` = %d and `showroomid` = %d " ,$productid , $showroomid ) ;
			$result = db_fetch_object($result_handle) ; 
			$old_quantity  =  $result->quantity ; 	
			$old_price  =  $result->price ;
			$old_total_price = $old_price*$old_quantity ; 
			$old_new_quantity =  $old_quantity + $quantity ; 
			$old_new_total_price =  $old_total_price 	+ $total_price ; 
			$old_new_unit_price = $old_new_total_price/$old_new_quantity ; 
			if((is_float($old_new_quantity) || is_int($old_new_quantity)) && (is_float($old_new_unit_price) || is_int($old_new_unit_price)) && $old_new_quantity != 0 &&  $old_new_unit_price != 0 ){ 
				db_query("update `joury_showroom` set `quantity` = %f , `price` = %f where showroomid=%d and productid=%d ",$old_new_quantity ,$old_new_unit_price,$showroomid,$productid )	 ; 		

			}else {
				echo "<div class='message error' > Bad input..!! </div>" ; 	
			}

		}else{
					db_query("insert into `joury_showroom` (`showroomid`,`showroomname`,`productid`,`productname`,`quantity`,`price`) values (%d,'%s',%d,'%s',%d,%f)",$showroomid,$showroomname,$productid,$productname,$quantity,$price ) ; 						 		
			}
			
			
		// the end of inserting data into joury_showroom table	





		
		
	}	
		if($returnedmoney != 0){
			drupal_set_message("<div class='message ok'><center>successfully returned....money back amount =  ".$returnedmoney." </center></div>") ; 
		}	
	}
}	



echo "<center><table id='return_products'>" ; 
	echo "<tr>" ; 
		echo "<td>" ; 
			_print_select_input_type_clients('clientid','joury_clients','firstname','cid','') ; 
		echo "</td>" ; 
		echo "<td>" ; 
			$timestamp = time();
			$date = date("m/d/Y", $timestamp) ;
			echo "<input type='text' name='date' id='date' value='{$date}' />" ; 
		echo "</td>" ; 
		echo "<td>" ; 
			echo "<input type='submit' name='getproducts' id='getproducts' value='GET PRODUCTS' />" ; 
		echo "</td>" ; 
	echo "</tr>" ; 
	echo "<tr>" ; 
		echo "<td id='returned-products-table-ajax-content' colspan='3'>" ; 
		echo "</td>" ;
	echo "</tr>" ; 
echo "</table></center>" ; 