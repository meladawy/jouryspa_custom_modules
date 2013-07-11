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
drupal_add_js($module_path."/staff_report_page.js") ;  
drupal_add_css($module_path."/staff_report_page.css") ;  
drupal_add_js( array('frontpage' => $url) , 'setting') ; 


echo drupal_get_form('joury_report_client_debt_payment_form') ; 






if (!empty($_SESSION['clientid']) && !empty($_SESSION['datefrom']) && !empty($_SESSION['dateto'])){
	$clientid = $_SESSION['clientid'] ; 
	$clientdata = _get_client_by_id($clientid) ;
	$datefrom = $_SESSION['datefrom'] ; 
	$dateto = $_SESSION['dateto'] ; 

	


		$client_debt_log = _get_client_debt_payment_log($clientid,$datefrom,$dateto) ; 
		$number_if_log = count($client_debt_log) ;  // number of canceled services
		if(count($client_debt_log) == 0){		
			echo "<div class='messag error'><center>NO DATA</center></div>" ; 
		}else{
			echo "<a href='#' id='printer-link' ><img src='$printimg_url' width='30'/></a>" ; 
			echo "<table id='staff-report-table' > " ;
				echo "<tr>" ; 
				
					echo "<td  id='head-row'>" ;
						echo "CLIENT NAME" ; 
					echo "</td>" ;
					
					echo "<td id='head-row'>" ;
						echo "SERVICE NAME" ; 					
					echo "</td>" ; 
					
					echo "<td id='head-row'>" ;
						echo "DATE OF DEBT PAYMENT" ; 	
					echo "</td>" ; 
										
					echo "<td id='head-row'>" ;
						echo "DEBT PAYMENT AMOUNT" ; 	
					echo "</td>" ;  
					
					echo "<td id='head-row'>" ;
						echo "TO CASHIER" ; 	
					echo "</td>" ;  
					 		
				echo "</tr>" ; 
				
				for($k=0 ; $k<$number_if_log ; $k++){
					$clientname = _get_client_name($client_debt_log[$k]->client_id) ; 
					$service_register_data =  _get_register_data_by_rid($client_debt_log[$k]->register_id) ; 
					$service_data = _get_service_by_id($service_register_data->sid) ; 
					$cashier = user_load($client_debt_log[$k]->cashier_id) ;
				echo "<tr>" ; 
				
					echo "<td>" ;
						echo $clientname ; 
					echo "</td>" ;
					
					echo "<td>" ;
						echo $service_data->name ; 				
					echo "</td>" ; 
					
					echo "<td>" ;
						echo $client_debt_log[$k]->date ; 				
					echo "</td>" ; 					
					
					echo "<td>" ;
						echo $client_debt_log[$k]->pay_amount ; 	 	
					echo "</td>" ;  
					
					echo "<td>" ;
						echo $cashier->name ; 
					echo "</td>" ;  
					
										
				echo "</tr>" ; 						
				}	
			echo "</table>" ; 			
		}		
	
	
	
	

	
	
	
	$_SESSION = array() ; 
}	
