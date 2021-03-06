<?php
// $Id$

$module_path = drupal_get_path('module' , 'joury_register_service') ;
$url = url('',array('absolute' => TRUE));
drupal_add_js($module_path."/jquery-1.6.1.min.js") ;  
drupal_add_js($module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_css($module_path."/fancybox/jquery.fancybox-1.3.4.css") ;
drupal_add_js($module_path."/js/jquery-ui-1.8.14.custom.min.js") ;
drupal_add_css($module_path."/smoothness/jquery-ui-1.8.14.custom.css") ;
drupal_add_js($module_path."/js/jquery-ui-timepicker-addon.js") ;
drupal_add_js($module_path."/js/jquery.printElement.js") ;
drupal_add_js($module_path."/contract_page.js") ;  
drupal_add_css($module_path."/contract_page.css") ;  
$printimg_url = url($module_path."/print.gif", array('absoluter' => TRUE)) ;  
drupal_add_js( array('frontpage' => $url) , 'setting') ; 
global $user ; 

// filter the argument
$arg4 = arg(4) ; 
if(empty($arg4)){
	drupal_goto('') ; 	
}	


if(!empty($arg4)){
	$rid_arr = explode('-',$arg4);	
	foreach($rid_arr as $val){
		if(!empty($val)){
			$rid_array[] = $val ; 
		}		
	}	
}

$contract_counter = 0 ; 


// print the contract
foreach($rid_array as $rid){
$register_data = _get_register_data_by_rid($rid) ; 
$client_id = 	$register_data->cid ;
$client = _get_client_by_id($client_id) ;  
$service_id = $register_data->sid ;	
$service = _get_service_by_id($service_id) ; 
$startdate = _get_start_date_of_rid($register_data->id) ; 
$service_nid = $service->nid ;
$service_node = node_load($service_nid) ; 
$contract =  $service_node->body ; 
$timestamp = time(); 
$date = date("m/d/Y" , $timestamp) ; 
$time = date("h:i:s A " , $timestamp) ; 
echo "<div style='float:right; margin-bottom:100px;'><a href='{$url}/joury/register/service/spa' id='back-home'>NEW SPA SERVICE</a></div>" ; 


echo "<table id='joury-contract-table' dir='rtl'>" ; 
	echo "<tr>";
		echo "<td id='print-row'>" ; 
			echo "<a href='#' id='printer-link' ><img src='$printimg_url' width='30'/></a>" ; 
		echo "</td>" ; 	
	echo "</tr>" ;
	
	echo "<tr>" ; 
		echo "<td colspan='2' style='text-align:center;' >"  ;
			echo "<strong>SN:</strong>".$register_data->id ; 
		echo "</td>" ; 	
	
	
		echo "<td colspan='2' style='text-align:right;'  >"  ;
			echo "<strong>CASHIER:</strong>".$user->uid."  - ".$register_data->date ; 
		echo "</td>" ; 
	echo "</tr>" ; 		
	
	
	echo "<tr>" ; 
		echo "<td colspan='4'>" ;
			echo "<h1><center>  عقد إشتراك </center></h1>" ; 
		echo "</td>" ; 
	echo "</tr>" ;
	
	
	
	echo "<tr>" ; 
		echo "<td>" ;
			echo "<h3> بيانات المشتركة: </h3>" ; 
		echo "</td>" ; 
	echo "</tr>" ;
	
	
	echo "<tr>" ; 
		echo "<td>" ;
			echo "<strong> الإسم: </strong>" ; 
		echo "</td>" ; 
		
		echo "<td>" ;
			echo $client->firstname." ".$client->lastname ; 
		echo "</td>" ; 
			
		echo "<td>" ;
			echo "<strong> تاريخ الميلاد: </strong>" ; 
		echo "</td>" ; 
		
		echo "<td >" ;
			echo $client->birthdate ; 
		echo "</td>" ; 
	echo "</tr>" ;	


	echo "<tr>" ; 
		echo "<td>" ;
			echo "<strong> رقم المنزل: </strong>" ; 
		echo "</td>" ; 
		
		echo "<td>" ;
			echo $client->phone ; 
		echo "</td>" ; 
	
		echo "<td>" ;
			echo "<strong> رقم النقال: </strong>" ; 
		echo "</td>" ; 
		
		echo "<td>" ;
			echo $client->mobile ; 
		echo "</td>" ; 		
	echo "</tr>" ;		
	
	
	
	
	
	echo "<tr>" ; 
		echo "<td>" ;
			echo "<h3> بيانات الإشتراك: </h3>" ; 
		echo "</td>" ; 
	echo "</tr>" ;	
	echo "<tr>" ; 
	
		echo "<td>" ;
			echo "<strong> تاريخ البداية: </strong>" ; 
		echo "</td>" ; 
		
		echo "<td dir='ltr' style='float:right;' >" ;
			echo $startdate  ; 
		echo "</td>";
	
		echo "<td>" ;
			echo "<strong> نوع الإشتراك: </strong>" ; 
		echo "</td>" ; 
		
		echo "<td>" ;
			echo $service->name ; 
		echo "</td>" ; 	

	echo "</tr>" ;		
	
	
	echo "<tr>" ; 
	
		echo "<td>" ;
			echo "<strong> قيمة الإشتراك: </strong>" ; 
		echo "</td>" ; 
		
		echo "<td>" ;
			echo $service->price." KWD" ; 
		echo "</td>" ; 		
	
	
		echo "<td>" ;
			echo "<strong> عدد الجلسات: </strong>" ; 
		echo "</td>" ; 
		
		echo "<td>" ;
			echo $service->sessionsnum  ; 
		echo "</td>";
		
	echo "</tr>" ; 
	
	echo "<tr>" ; 
		echo "<td>" ;
			echo "<strong> المبلغ المدفوع: </strong>" ; 
		echo "</td>" ; 
		
		echo "<td>" ;
			echo $register_data->paid." KWD" ; 
		echo "</td>" ; 	

	
		echo "<td>" ;
			echo "<strong> طريقة الدفع: </strong>" ; 
		echo "</td>" ; 
		
		echo "<td>" ;
			echo $register_data->payment_method  ; 
		echo "</td>";



	echo "</tr>" ;	
	
	
	echo "<tr>" ; 
		echo "<td>" ;
			echo "<h3> بنود العقد :</h3>" ; 
		echo "</td>" ; 
	echo "</tr>" ;	
	echo "<tr>" ; 	
	
	
		echo "<tr>" ; 
	
		echo "<td colspan='4'  style='text-align: justify;'>" ;
			echo check_markup($contract);
		echo "</td>" ; 	

	echo "</tr>" ;	
	
	echo "<tr>" ; 
		echo "<td style='text-align: center; padding-right:50%;' colspan='4'>";
			echo "<strong>توقيع المشتركة : </strong>" ;
		echo "</td>" ; 
	echo "</tr>" ; 
	
	
	
echo "</table>" ;  
$contract_counter += 1 ; 
}	 	