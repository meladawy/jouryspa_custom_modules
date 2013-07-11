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


echo drupal_get_form('joury_report_staff_form') ; 


if (!empty($_SESSION['staffid']) && !empty($_SESSION['datefrom']) && !empty($_SESSION['dateto']) && !empty($_SESSION['storeid']) ){
	$staffid = $_SESSION['staffid'] ; 
	$staffname = _get_staff_name($staffid) ;
	$storeid = $_SESSION['storeid'] ;  
	$datefrom = $_SESSION['datefrom'] ; 
	$dateto = $_SESSION['dateto'] ; 
	


		$staffdata = _get_staff_rent_log($staffid,$storeid,$datefrom,$dateto) ; 
		$number_if_staffdata = count($staffdata) ; 
		dsm($staffname) ; 
		if(count($staffdata) == 0){		
			echo "<div class='messag error'><center>NO DATA</center></div>" ; 
		}else{
			echo "<a href='#' id='printer-link' ><img src='$printimg_url' width='30'/></a>" ; 
			echo "<table id='staff-report-table' > " ;
				echo "<tr>" ; 
				
					echo "<td  id='head-row'>" ;
						echo "staff NAME" ; 
					echo "</td>" ;
					
					echo "<td id='head-row'>" ;
						echo "PRODUCT NAME" ; 					
					echo "</td>" ; 
					
					echo "<td id='head-row'>" ;
						echo "FROM STORE" ; 	
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
										
				echo "</tr>" ; 
				
				for($k=0 ; $k<$number_if_staffdata ; $k++){
				echo "<tr>" ; 
				
					echo "<td>" ;
						echo $staffdata[$k]->staffname ; 
					echo "</td>" ;
					
					echo "<td>" ;
						echo $staffdata[$k]->productname ; 				
					echo "</td>" ; 
					
					echo "<td>" ;
						echo $staffdata[$k]->storename ; 				
					echo "</td>" ; 					
					
					echo "<td>" ;
						echo $staffdata[$k]->quantity ;  	
					echo "</td>" ;  
					
					echo "<td>" ;
						echo $staffdata[$k]->date ; 
					echo "</td>" ;  
					
					echo "<td>" ;
						echo $staffdata[$k]->price ;  	
					echo "</td>" ;  
										
				echo "</tr>" ; 						
				}	
			echo "</table>" ; 			
		}		
	
	
	
	
	if($operation == 'imports'){
		
	}	
	
	
	
	$_SESSION = array() ; 
}	
