<?php
// $Id$

/**
* @stores : 
* array of objects..each array element contain  store data
*/
$current_module_path = drupal_get_path('module' , 'joury_store') ; 
$siteurl = url('', array('absolute' => TRUE)) ; 
drupal_add_js($current_module_path."/jquery-1.4.3.min.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_js($current_module_path."/js/jquery-ui-1.8.14.custom.min.js") ;
drupal_add_css($current_module_path."/smoothness/jquery-ui-1.8.14.custom.css") ;
drupal_add_css($current_module_path."/fancybox/jquery.fancybox-1.3.4.css") ;
drupal_add_css($current_module_path."/joury_store.css") ;
drupal_add_js($current_module_path."/joury_store.js") ;
drupal_add_js(array('url' => $siteurl) , 'setting'  ); 
$number_of_stores =  count($stores) ; 
$ajax = url('ajax/store/products/',array('absolute' => TRUE)) ;

if(!empty($_POST['make-request'])){
	$author = $_POST['author'] ; 
	$date = $_POST['date'] ; 
	$storeid = $_POST['storeid'] ;
	$storename = _get_store_name($storeid) ; 
	foreach($_POST as $key => $val){
		if($val == 'on'){
			$id = substr($key,7,2425) ;
			$productid_arr[] = $_POST['productid-'.$id] ; 
			$quantity_arr[] = $_POST['quantity-'.$id] ; 
			$productname_arr[] = $_POST['productname-'.$id] ; 
		}	
	}
	$number_of_updates = count($productid_arr); 
	if($number_of_updates == 0){
		return  ; 	
	}

	
	for($m=0 ; $m< $number_of_updates ; $m++){
		$productid = $productid_arr[$m] ; 
		$productname = $productname_arr[$m] ; 
		$quantity = $quantity_arr[$m] ; 
		
		if($quantity == 0 && $productid == 0){
			return ; 
		}
		
		db_query("insert into `joury_store_requests`  (`productid`,`productname` ,`quantity`, `storeid`,`storename`,`status`,`date`,`author` ) 
		values (%d,'%s',%d,%d,'%s',%d,'%s','%s')",
		$productid,$productname, $quantity,$storeid,$storename,0,$date,$author) ; 
	}
	drupal_set_message("<div class='message ok' ><center>REQUEST DONE ..</center></div>") ; 	

} // end of post data process

global $user ; 
$staff_center = $user->centerdetails ; 

$m = 0 ;  


echo "<table id='joury-store-stores' >" ;
if(user_access("override centers division")){	
	$m++ ; 
	for($k=0 ; $k < $number_of_stores ; $k++){
		echo "<tr>" ; 
			echo "<td id='joury-store-stores-row'>" ;
				echo "<div  id='store-container' ><a href='$ajax".$stores[$k]->sid."' id='store' > ".$stores[$k]->name." </a></div>"  ; 
			echo "</td>";
		echo "<tr>" ;  
	 }	
}else{

	for($k=0 ; $k < $number_of_stores ; $k++){

		if($staff_center == $stores[$k]->center){
			
		$m++ ; 
		echo "<tr>" ; 
			echo "<td id='joury-store-stores-row'>" ;
				echo "<div  id='store-container' ><a href='$ajax".$stores[$k]->sid."' id='store' > ".$stores[$k]->name." </a></div>"  ; 
			echo "</td>";
		echo "<tr>" ;  
		}		
	}		
}	
 echo "</table>" ;
 
 if($m == 0) {
	drupal_set_message("<div class='message error'><center>NO STORES AVAILABLE</center></div>") ;	
}	 
 
 
 

 