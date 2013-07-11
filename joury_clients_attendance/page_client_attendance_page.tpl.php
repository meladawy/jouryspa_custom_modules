<?php
// $Id$

/**
* @clientid
*/

$module_path = drupal_get_path('module' , 'joury_clients_attendance') ;
$url = url('',array('absolute' => TRUE));
drupal_add_js($module_path."/jquery-1.6.1.min.js") ;  
drupal_add_js($module_path."/clients_page.js") ;  
drupal_add_css($module_path."/clients_page.css") ;  
drupal_add_js( array('frontpage' => $url) , 'setting') ; 

$services = _get_services_of_client_id($clientid) ; 
$number_of_services = count($services) ; 

if($number_of_services > 0){
	$client = _get_client_by_id($clientid) ; 
	echo "<fieldset>"; 
	echo "<legend>CLIENT INFO</legend>" ; 
	echo "<strong> CLIENT NAME: </strong>".$client->firstname." ".$client->lastname ; 
	echo "<br/>" ; 
	echo "<strong> BIRTH DATE: </strong>".$client->birthdate; 
	echo "<br/>" ; 	
	echo "<strong> PHONE: </strong>".$client->phone ; 
	echo "</fieldset>" ;
	

	echo "<table id='client-page-attendance-table'>" ; 
	
	echo "<tr>" ; 
			echo "<td>" ; 
				echo "<div id='page-register-admin-table-row-head'>SERVICE NAME</div>";
			echo "</td>" ; 
			
			echo "<td>" ; 
				echo "<div id='page-register-admin-table-row-head'>SESSIONS NUMBER</div>";
			echo "</td>" ; 
			
			echo "<td>" ; 
				echo "<div id='page-register-admin-table-row-head'>STARTED AT</div>";
			echo "</td>" ; 
			
			echo "<td>" ; 
				echo "<div id='page-register-admin-table-row-head'>CENTER NAME</div>";
			echo "</td>" ; 
		echo "</tr>" ; 
	for($k=0 ; $k< $number_of_services ;  $k++){
		$service=  _get_service_by_id($services[$k]->sid) ; 
		$url_service_page = $url."clients/attendance/".$clientid."/".$services[$k]->id ; 
		echo "<tr>" ; 
			echo "<td>" ; 
				echo l($service->name,$url_service_page);
			echo "</td>" ; 
			
			echo "<td>" ; 
				echo l($service->sessionsnum,$url_service_page);
			echo "</td>" ; 
			
			echo "<td>" ; 
				echo l($services[$k]->date,$url_service_page);
			echo "</td>" ; 
			
			echo "<td>" ; 
				echo l($services[$k]->centername,$url_service_page);
			echo "</td>" ; 
		echo "</tr>" ; 	
	}
	echo "</table>" ; 
	
}else{
	echo "<div class='message error'><center> NO SERVICES OPENED TO THIS CLIENT </center></div>" ; 	
}	