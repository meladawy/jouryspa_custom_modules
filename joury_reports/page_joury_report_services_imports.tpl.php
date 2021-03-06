<?php
// $Id$

$another_module_path = drupal_get_path('module' , 'joury_register_service') ;
$module_path = drupal_get_path('module' , 'joury_reports') ;
$url = url('',array('absolute' => TRUE));
$printimg_url = url($module_path."/print.gif", array('absoluter' => TRUE)) ;  
drupal_add_js($another_module_path."/jquery-1.6.1.min.js") ;  
drupal_add_js($another_module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($another_module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_css($another_module_path."/fancybox/jquery.fancybox-1.3.4.css") ;
drupal_add_js($another_module_path."/js/jquery-ui-1.8.14.custom.min.js") ;
drupal_add_css($another_module_path."/smoothness/jquery-ui-1.8.14.custom.css") ;
drupal_add_js($another_module_path."/js/jquery-ui-timepicker-addon.js") ;
drupal_add_js($another_module_path."/js/jquery.printElement.js") ;
drupal_add_js($module_path."/service_report_page.js") ;  
drupal_add_css($module_path."/service_report_page.css") ;  
drupal_add_js( array('frontpage' => $url) , 'setting') ; 

echo drupal_get_form('joury_report_services_imports_form') ; 

echo "<br/>" ;


if(!empty($_COOKIE['center-name'])  && !empty($_COOKIE['service-id'])  && !empty($_COOKIE['date-from']) && !empty($_COOKIE['date-to'])){

	$centername =  $_COOKIE['center-name'] ;
	$serviceid = $_COOKIE['service-id'] ;
	$datefrom = $_COOKIE['date-from'] ; 
	$dateto = $_COOKIE['date-to'] ; 
	 
	if($centername == 'all' && $serviceid == 'all'){
		$register_data_handle = db_query("select * from {joury_client_services_register} where `date` between '%s' and '%s'" ,$datefrom,$dateto);
	}elseif($centername == 'all' && $serviceid != 'all') {
		$register_data_handle = db_query("select * from {joury_client_services_register} where `date` between '%s' and '%s'  and `sid` = %d 
		" ,$datefrom,$dateto,$serviceid);
	}elseif($centername != 'all' && $serviceid == 'all') {	
		$register_data_handle = db_query("select * from {joury_client_services_register} where `date` between '%s' and '%s'  and `centername` = '%s' " ,
		$datefrom,$dateto,$centername);
	}else{
		$register_data_handle = db_query("select * from {joury_client_services_register} where `date` between '%s' and '%s'  and `sid` = %d 
		and `centername` = '%s' " ,$datefrom,$dateto,$serviceid,$centername);
	}	
	while($register_date_obj = db_fetch_object($register_data_handle)){
		$cid[] = 	$register_date_obj->cid ; 
		$clientname[] = _get_client_name($register_date_obj->cid) ; 
		$date[] = $register_date_obj->date ; 
		$sid[] =  $register_date_obj->sid ; 
		$rid[] = $register_date_obj->id ; 
		$kenet_cardid[] = _get_kenet_card_id($register_date_obj->id) ; 
		$service = _get_service_by_id($register_date_obj->sid) ; 
		$servicename[] = $service->name;  
		$serviceprice[] = $service->price;  
		$paid[] =    $register_date_obj->paid ;
		$payment_method[] = $register_date_obj->payment_method ;
		$room[] = $register_date_obj->room ;
		$by[] = $register_date_obj->by ;
		$centersname[] = $register_date_obj->centername ;
		$results[] = $register_date_obj  ; 
	} 
	$number_of_register_data = count($cid) ; 
	if($number_of_register_data == 0 ){
		drupal_set_message("<div class='message error' ><center> NO RESULT </center></div>") ; 	
		return ; 
	}	
	echo "<a href='#' id='printer-link' ><img src='$printimg_url' width='30'/></a>" ;
	echo "<table id='service-report-table' >  " ; 
		echo "<tr>" ;
			echo "<td id='head-row' >" ; 
				echo "CLIENT NAME" ; 
			echo "</td>" ; 

			echo "<td id='head-row' >" ; 
				echo "CENTER NAME" ; 
			echo "</td>" ; 			
			
			echo "<td id='head-row' >" ; 
				echo "SERVICE NAME" ; 
			echo "</td>" ; 
			
			echo "<td id='head-row' >" ; 
				echo "SERVICE PRICE" ; 
			echo "</td>" ; 
			
			echo "<td id='head-row' >" ; 
				echo "PAID" ; 
			echo "</td>" ; 

			echo "<td id='head-row' >" ; 
				echo "PAYMENT METHOD" ; 
			echo "</td>" ; 
			
			echo "<td id='head-row' >" ; 
				echo "KENET CARD ID" ; 
			echo "</td>" ; 						
			echo "<td id='head-row' >" ; 
				echo "DATE" ; 
			echo "</td>" ; 			
		echo "</tr>" ; 
		$kenet_total = 0 ; 
		$cash_total = 0 ; 
	 for($k=0 ; $k<$number_of_register_data ; $k++){	
		echo "<tr>" ;
			echo "<td>" ; 
				echo $clientname[$k] ; 
			echo "</td>" ; 
			
			echo "<td>" ; 
				echo $centersname[$k] ; 
			echo "</td>" ; 
			
			echo "<td>" ; 
				echo $servicename[$k] ; 
			echo "</td>" ; 
			
			echo "<td>" ; 
				echo $serviceprice[$k] ; 
			echo "</td>" ; 
			
			echo "<td>" ; 
				echo $paid[$k] ; 
			echo "</td>" ; 

			echo "<td>" ; 
				echo $payment_method[$k] ; 
			echo "</td>" ; 
			
			echo "<td>" ; 
				echo $kenet_cardid[$k] ; 
			echo "</td>" ;			
						
			echo "<td>" ; 
				echo $date[$k] ; 
			echo "</td>" ;
			
			if($payment_method[$k] == 'cash'){
				$cash_total += $paid[$k] ; 
			}else{
				$kenet_total += $paid[$k] ; 
			}		
		echo "</tr>" ; 
		}
		echo "<tr>" ; 
			echo "<td colspan='3'>" ;
				echo "<strong>TOTAL CASH MONEY:</strong>" ; 
			echo "</td>" ; 
			
			echo "<td colspan='5'>" ;
				echo $cash_total ." KWD" ; 
			echo "</td>" ; 			
		echo "</tr>" ; 
		
		echo "<tr>" ; 
			echo "<td colspan='3'>" ;
				echo "<strong>TOTAL KENET MONEY:</strong>" ; 
			echo "</td>" ; 
			
			echo "<td colspan='5'>" ;
				echo $kenet_total ." KWD" ; 
			echo "</td>" ; 			
		echo "</tr>" ; 
		
		
	echo "</table>" ; 
}	