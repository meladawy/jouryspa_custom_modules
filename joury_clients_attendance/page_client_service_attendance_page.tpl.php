<?php
// $Id$

/**
* @clientid
* @registerid
*/

$module_path = drupal_get_path('module' , 'joury_clients_attendance') ;
$url = url('',array('absolute' => TRUE));
$true_icon_url = url($module_path.'/true.jpg' ,array('absolute' => TRUE)) ; 
$false_icon_url = url($module_path.'/false.png' ,array('absolute' => TRUE)) ; 
drupal_add_js($module_path."/jquery-1.6.1.min.js") ;  
drupal_add_js($module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_css($module_path."/fancybox/jquery.fancybox-1.3.4.css") ;
drupal_add_js($module_path."/js/jquery-ui-1.8.14.custom.min.js") ;
drupal_add_css($module_path."/smoothness/jquery-ui-1.8.14.custom.css") ;
drupal_add_js($module_path."/js/jquery-ui-timepicker-addon.js") ;
drupal_add_js($module_path."/clients_service_page.js") ;  
drupal_add_css($module_path."/clients_service_page.css") ;  
drupal_add_js( array('frontpage' => $url) , 'setting') ; 


$register_data = _get_data_of_clientid_and_registerid($registerid) ; 
$client =  _get_client_by_id($clientid) ; 
if(empty($register_data) || empty($client)){
	echo "<div class='message error'><center>NOT EXIST OR MAYBE CLOSED</center></div>" ; 	
	return ;
}	
$service_data = _get_service_by_id($register_data->sid) ; 
$sessions_number = $service_data->sessionsnum ; 
echo drupal_get_form('client_service_sessions_form' , $sessions_number,$registerid) ;  // print form













// print table
$sessions = _get_sessions_of_registerid($register_data->id) ; 
$sessionsnumber = count($sessions)  ; 
if($sessionsnumber>0){
	
	$service_size_array  = explode(" , ", $service_data->size_nid);
		foreach($service_size_array as $key => $val){
			if(!empty($val)){
				$size_node = node_load($val) ; 
				$size[] = $size_node->title ; 
				$size_nid[]  =  $size_node->nid ; 
			}		
		}	
		$number_of_size_fields = count($size) ; 
		
	echo "<table id='client-service-info' >" ; 
		echo "<tr> " ;
				echo "<td id='page-register-admin-table-row-head'>" ; 
					echo "SESSION" ; 
				echo "</td>" ;  
			
				echo "<td id='page-register-admin-table-row-head'>" ; 
					echo "DATE" ; 
				echo "</td>" ; 
			
			for($k=0 ; $k<$number_of_size_fields ; $k++){
				echo "<td id='page-register-admin-table-row-head'>" ; 
					echo strtoupper($size[$k]) ; 
				echo "</td>"	;	
			}	
			
				echo "<td id='page-register-admin-table-row-head'>" ; 
					echo "ATTENDANCE" ; 
				echo "</td>" ; 
		echo "</tr>" ; 

		for($k=0 ; $k < $sessionsnumber ; $k++){
			$session = $sessions[$k] ; 

			$date = _get_date_of_sessionid($session ,$register_data->id) ;
			$attend  = _get_attend_of_sessionid($session ,$register_data->id) ;
			echo "<tr>" ; 
			
				echo "<td>" ;
					echo $session ; 
				echo "</td>" ;
				
				echo "<td>" ;
					echo $date ; 
				echo "</td>" ;
				
				for($m=0 ; $m<$number_of_size_fields ; $m++){
				echo "<td>" ; 
				  $column_value = _get_column_value($size_nid[$m],$session,$registerid) ;
					echo $column_value ; 
				echo "</td>"	;	
				}	
				
				echo "<td>" ; 
					echo ($attend == 1) ? "<img src='{$true_icon_url}'  width='27'/>" : "<img src='{$false_icon_url}'   width='27' />" ; 
				echo "</td>" ;				
				
			echo "</tr>" ;  	
		}	

	echo "</table>" ; 
}	


