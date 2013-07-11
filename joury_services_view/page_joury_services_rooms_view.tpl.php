<?php
// $Id$

$another_module_path = drupal_get_path('module' , 'joury_clients_attendance') ;
$module_path =  drupal_get_path('module' , 'joury_services_view') ;
$url = url('',array('absolute' => TRUE));
drupal_add_js($another_module_path."/jquery-1.6.1.min.js") ;  
drupal_add_js($another_module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($another_module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_css($another_module_path."/fancybox/jquery.fancybox-1.3.4.css") ;
drupal_add_js($another_module_path."/js/jquery-ui-1.8.14.custom.min.js") ;
drupal_add_css($another_module_path."/smoothness/jquery-ui-1.8.14.custom.css") ;
drupal_add_js($another_module_path."/js/jquery-ui-timepicker-addon.js") ;
drupal_add_js($module_path."/joury_services_view.js") ;
drupal_add_css($module_path."/joury_services_view.css") ;
drupal_add_js( array('frontpage' => $url) , 'setting') ; 


echo drupal_get_form('service_timetable_form') ; 

if(!empty($_SESSION['room']) && !empty($_SESSION['center']) && !empty($_SESSION['date'])){

	$room = $_SESSION['room'] ;
	$center = $_SESSION['center'] ;
	$date = $_SESSION['date'] ;

	
	if($room == 'all'){ // table for all rooms
		$rooms = _get_all_rooms() ; 

		if(count($rooms) != 0){
		foreach($rooms as $roomname){
			$register[] = get_register_of_room($roomname, $center,$date)  ; 	
		}

		foreach($register as $roomelement){ // get not empty rooms
			if(!empty($roomelement)){
				$busy_rooms[] = $roomelement ; 
			}		
		}
		
		$number_of_busy_rooms = count($busy_rooms) ;
		if($number_of_busy_rooms != 0){
		foreach($busy_rooms as $busyroom ){
			$number_of_records_per_day[] = count($busyroom) ; 	
		}
		$number_of_columns = max($number_of_records_per_day) ; 
		$number_of_rows = count($busy_rooms) ; 
		
		echo "<table id='service-time-table'>" ; 
		for($k=0 ; $k<$number_of_rows ; $k++){
			echo "<tr>" ; 
				echo "<td id='jouryspa-page-view-head'>" ;  // print rooms
					echo $busy_rooms[$k][0]->room ; 
				echo "</td>" ; 
				
				$number_of_room_records = count($busy_rooms[$k]) ; 
				
				for($m=0 ; $m<$number_of_room_records ; $m++){
					$timedate = substr($busy_rooms[$k][$m]->date,11,211) ;
					$timeby =  $busy_rooms[$k][$m]->by ; 
					$registerdata = _get_register_data_by_rid($busy_rooms[$k][$m]->rid) ; 
					$timeclientobject = _get_client_by_id($registerdata->cid) ; 
					echo "<td>" ; 
						
						echo "<table>" ; 
							echo "<tr>" ; 
								echo "<td>" ; 
									echo "<strong>DATE:</strong>".$timedate ; 
								echo "</td>" ; 	
							echo "</tr>" ; 	
						
							echo "<tr>" ; 
								echo "<td>" ; 
									echo "<strong>BY:</strong>".$timeby ; 
								echo "</td>" ; 	
							echo "</tr>" ; 	
							
							echo "<tr>" ; 
								echo "<td>" ; 
									echo "<strong>CLIENT:</strong>".$timeclientobject->firstname." ".$timeclientobject->lastname ; 
								echo "</td>" ; 	
							echo "</tr>" ; 

							echo "<tr>" ; 
								echo "<td>" ; 
									echo "<strong>PHONE:</strong>".$timeclientobject->phone ; 
								echo "</td>" ; 	
							echo "</tr>" ; 	
							
							echo "<tr>" ; 
								echo "<td>" ; 
									echo "<strong>MOBILE:</strong>".$timeclientobject->mobile ; 
								echo "</td>" ; 	
							echo "</tr>" ; 								
														
															
							echo "<tr>" ; 
								echo "<td>" ; 
									echo  l('SERVICE-DETAILS' ,
											'clients/attendance/'.$registerdata->cid."/".$registerdata->id,
											array('attributes' => array(
     									 'id' => 'attendance-link',)) ) ; 
								echo "</td>" ; 	
							echo "</tr>" ; 	
																						
					 	echo "</table>" ; 	
												
					echo "</td>" ; 	
				}	
			echo "<tr>" ; 
		}
		echo "</table>" ; 	
		}else{
			echo "NO REGISTRATION IN THIS DAY" ; 	
		}
		}else{
			echo "NO REGISTRATION IN THIS DAY" ;
		}		
	}		
	
	
	
	// print table for specific room
	
	if($room != 'all'){
		$register = get_register_of_room($room, $center,$date)  ; 
		$number_of_records_per_day = count($register) ; 	
		$number_of_columns = $number_of_records_per_day ; 
		$number_of_rows = 1 ; 
	if($number_of_columns != 0 ){
	echo "<table id='service-time-table'>" ; 
		for($k=0 ; $k<$number_of_rows ; $k++){
			echo "<tr>" ; 
				echo "<td id='jouryspa-page-view-head'>" ;  // print rooms
					echo $register[0]->room ; 
				echo "</td>" ; 
				
				$number_of_room_records = count($register) ; 
				
				for($m=0 ; $m<$number_of_room_records ; $m++){
					$timedate = substr($register[$m]->date,11,211) ;
					$timeby =  $register[$m]->by ; 
					$registerdata = _get_register_data_by_rid($register[$m]->rid) ; 
					$timeclientobject = _get_client_by_id($registerdata->cid) ; 
					echo "<td>" ; 
						
						echo "<table>" ; 
							echo "<tr>" ; 
								echo "<td>" ; 
									echo "<strong>DATE:</strong>".$timedate ; 
								echo "</td>" ; 	
							echo "</tr>" ; 	
						
							echo "<tr>" ; 
								echo "<td>" ; 
									echo "<strong>BY:</strong>".$timeby ; 
								echo "</td>" ; 	
							echo "</tr>" ; 	
							
							echo "<tr>" ; 
								echo "<td>" ; 
									echo "<strong>CLIENT:</strong>".$timeclientobject->firstname." ".$timeclientobject->lastname ; 
								echo "</td>" ; 	
							echo "</tr>" ; 

							echo "<tr>" ; 
								echo "<td>" ; 
									echo "<strong>PHONE:</strong>".$timeclientobject->phone ; 
								echo "</td>" ; 	
							echo "</tr>" ; 	
							
							echo "<tr>" ; 
								echo "<td>" ; 
									echo "<strong>MOBILE:</strong>".$timeclientobject->mobile ; 
								echo "</td>" ; 	
							echo "</tr>" ; 								
														
															
							echo "<tr>" ; 
								echo "<td>" ; 
									echo  l('SERVICE-DETAILS' ,
											'clients/attendance/'.$registerdata->cid."/".$registerdata->id,
											array('attributes' => array(
     									 'id' => 'attendance-link',)) ) ; 
								echo "</td>" ; 	
							echo "</tr>" ; 	
																						
					 	echo "</table>" ; 	
												
					echo "</td>" ; 	
				}	
			echo "<tr>" ; 
		}
		echo "</table>" ; 			
		}else{
			echo "NO REGISTRATION IN THIS DAY" ; 	
		}	
		
	}
	unset($_SESSION['room']) ; 	
	unset($_SESSION['center']) ; 	
	unset($_SESSION['date']) ; 	
}	