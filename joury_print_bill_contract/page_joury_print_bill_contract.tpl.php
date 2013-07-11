<?php
// $Id$
$another_module_path = drupal_get_path('module' , 'joury_register_service') ;
$module_path = drupal_get_path('module' , 'joury_print_bill_contract') ;
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
drupal_add_js($module_path."/print_bill_contract_page.js") ;  
drupal_add_css($module_path."/print_bill_contract_page.css") ;  
drupal_add_js( array('frontpage' => $url) , 'setting') ; 

echo drupal_get_form('joury_print_bill_contract_form') ; 

if(!empty($_SESSION['contract_data'])) {
 $contracts = $_SESSION['contract_data'] ; 	
 echo "<table id='service-report-table'> " ; 
 	echo "<tr>" ; 
 		echo "<td id='head-row'>";
 			echo "CLIENT NAME" ; 
 		echo "</td>" ; 
 		
  		echo "<td id='head-row' >";
 			echo "DATE" ; 
 		echo "</td>" ; 	

  		echo "<td id='head-row' >";
 			echo "RN" ; 
 		echo "</td>" ;
 		
  		echo "<td id='head-row' >";
 			echo "VIEW" ; 
 		echo "</td>" ; 	 		 		
 	echo "<tr>" ;

foreach($contracts as $contract){
	$clientdata = _get_client_by_id($contract->cid) ; 
	$contract_page_url = url('joury/register/service/contract/'.$contract->id , array('absolute' => TRUE)) ; 
 	echo "<tr>" ; 
 		echo "<td>";
 			echo $clientdata->firstname." ".$clientdata->lastname ; 
 		echo "</td>" ; 
 		
  		echo "<td>";
 			echo $contract->date ; 
 		echo "</td>" ; 	

  		echo "<td>";
 			echo $contract->id ; 
 		echo "</td>" ;
 		
  		echo "<td>";
 			echo "<a href='$contract_page_url' > VIEW </a>" ; 
 		echo "</td>" ; 	 		 		
 	echo "<tr>" ;	
}	 	
 	
 echo "</table>" ; 
}	
if(!empty($_SESSION['bill_data'])) {
 $bills = $_SESSION['bill_data'] ; 	
 echo "<table id='service-report-table' > " ; 
 	echo "<tr>" ; 
 		echo "<td id='head-row' >";
 			echo "CLIENT NAME" ; 
 		echo "</td>" ; 
 		
  		echo "<td id='head-row' >";
 			echo "DATE" ; 
 		echo "</td>" ; 	

  		echo "<td id='head-row' >";
 			echo "RN" ; 
 		echo "</td>" ;
 		
  		echo "<td id='head-row' >";
 			echo "VIEW" ; 
 		echo "</td>" ; 	 		 		
 	echo "<tr>" ;

foreach($bills as $bill){
	$clientdata = _get_client_by_id($bill->clientid) ; 
	$bill_page_url = url('joury/print/bill/'.$bill->id , array('absolute' => TRUE)) ; 
 	echo "<tr>" ; 
 		echo "<td>";
 			echo $clientdata->firstname." ".$clientdata->lastname ; 
 		echo "</td>" ; 
 		
  		echo "<td>";
 			echo $bill->date ; 
 		echo "</td>" ; 	

  		echo "<td>";
 			echo $bill->id ; 
 		echo "</td>" ;
 		
  		echo "<td>";
 			echo "<a href='$bill_page_url' > VIEW </a>" ; 
 		echo "</td>" ; 	 		 		
 	echo "<tr>" ;	
}	 	
 	
 echo "</table>" ; 
 
 
 
}	

$_SESSION = array() ; 


