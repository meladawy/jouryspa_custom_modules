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
drupal_add_js($module_path."/store_report_page.js") ;  
drupal_add_css($module_path."/store_report_page.css") ;  
drupal_add_js( array('frontpage' => $url) , 'setting') ; 


echo drupal_get_form('joury_report_stores_form') ; 


if (!empty($_SESSION['storename']) && !empty($_SESSION['operation']) && !empty($_SESSION['datefrom']) && !empty($_SESSION['dateto'])){
	$storename = $_SESSION['storename'] ; 
	$operation = $_SESSION['operation'] ; 
	$datefrom = $_SESSION['datefrom'] ; 
	$dateto = $_SESSION['dateto'] ; 
	


	if($operation == 'requests'){
		$storesdata = _get_store_requests_log($storename,$datefrom,$dateto) ; 
		$number_if_storedata = count($storesdata) ; 
		if(count($storesdata) == 0){
			echo "<div class='messag error'><center>NO DATA</center></div>" ; 
		}else{
			echo "<a href='#' id='printer-link' ><img src='$printimg_url' width='30'/></a>" ; 
			echo "<table id='stores-report-table' > " ;
				echo "<tr>" ; 
				
					echo "<td  id='head-row'>" ;
						echo "STORE NAME" ; 
					echo "</td>" ;
					
					echo "<td id='head-row'>" ;
						echo "PRODUCT NAME" ; 					
					echo "</td>" ; 
					
					echo "<td id='head-row'>" ;
						echo "QUANTITY" ; 	
					echo "</td>" ;  
					
					echo "<td id='head-row'>" ;
						echo "DATE" ; 	
					echo "</td>" ;  
					
					echo "<td id='head-row'>" ;
						echo "STATUS" ; 	
					echo "</td>" ;  

					echo "<td id='head-row'>" ;
						echo "BY" ; 	
					echo "</td>" ;  
										
				echo "</tr>" ; 
				
				for($k=0 ; $k<$number_if_storedata ; $k++){
				echo "<tr>" ; 
				
					echo "<td>" ;
						echo $storesdata[$k]->storename ; 
					echo "</td>" ;
					
					echo "<td>" ;
						echo $storesdata[$k]->productname ; 				
					echo "</td>" ; 
					
					echo "<td>" ;
						echo $storesdata[$k]->quantity ;  	
					echo "</td>" ;  
					
					echo "<td>" ;
						echo $storesdata[$k]->date ; 
					echo "</td>" ;  
					
					echo "<td>" ;
						if($storesdata[$k]->status ==1){
							echo "COMPLETED" ; 	
						}else{
							echo "WAITING" ; 	
						}		 	
					echo "</td>" ;  

					echo "<td>" ;
						echo $storesdata[$k]->author ;  	
					echo "</td>" ;  
										
				echo "</tr>" ; 						
				}	
			echo "</table>" ; 			
		}		
	}else{
		$storesdata = _get_store_imports_log($storename,$datefrom,$dateto) ; 
		$number_if_storedata = count($storesdata) ; 
		if(count($storesdata) == 0){
			echo "<div class='messag error'><center>NO DATA</center></div>" ; 
		}else{
			echo "<a href='#' id='printer-link' ><img src='$printimg_url' width='30'/></a>" ; 
			echo "<table id='stores-report-table' > " ;
				echo "<tr>" ; 
				
					echo "<td  id='head-row'>" ;
						echo "STORE NAME" ; 
					echo "</td>" ;
					
					echo "<td id='head-row'>" ;
						echo "PRODUCT NAME" ; 					
					echo "</td>" ; 
					
					echo "<td id='head-row'>" ;
						echo "QUANTITY" ; 	
					echo "</td>" ;  
					
					echo "<td id='head-row'>" ;
						echo "DATE" ; 	
					echo "</td>" ;  
					
					echo "<td id='head-row'>" ;
						echo "ITEM PRICE" ; 	
					echo "</td>" ;  

					echo "<td id='head-row'>" ;
						echo "BY" ; 	
					echo "</td>" ;  
										
				echo "</tr>" ; 
				
				for($k=0 ; $k<$number_if_storedata ; $k++){
				echo "<tr>" ; 
				
					echo "<td>" ;
						echo $storesdata[$k]->storename ; 
					echo "</td>" ;
					
					echo "<td>" ;
						echo $storesdata[$k]->productname ; 				
					echo "</td>" ; 
					
					echo "<td>" ;
						echo $storesdata[$k]->quantity ;  	
					echo "</td>" ;  
					
					echo "<td>" ;
						echo $storesdata[$k]->date ; 
					echo "</td>" ;  
					
					echo "<td>" ;
						echo $storesdata[$k]->price  ; 	
					echo "</td>" ;  

					echo "<td>" ;
						echo $storesdata[$k]->author ;  	
					echo "</td>" ;  
										
				echo "</tr>" ; 						
				}	
			echo "</table>" ; 			
		}				
		
		
	}
	
	
	
	
	if($operation == 'imports'){
		
	}	
	
	
	
	$_SESSION = array() ; 
}	