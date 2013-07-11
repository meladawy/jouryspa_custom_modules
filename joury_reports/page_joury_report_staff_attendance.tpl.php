<?php
// $Id$

$another_module_path = drupal_get_path('module' , 'joury_register_service') ;
$module_path = drupal_get_path('module' , 'joury_reports') ;
$url = url('',array('absolute' => TRUE));
$printimg_url = url($module_path."/print.gif", array('absoluter' => TRUE)) ;  
//drupal_add_js($another_module_path."/js/jquery-1.5.1.min.js") ; 
drupal_add_js($another_module_path."/js/jquery.printElement.js") ;
drupal_add_js($module_path."/staff_attendance_report_page.js") ;  
drupal_add_css($module_path."/staff_report_page.css") ;  
drupal_add_js( array('frontpage' => $url) , 'setting') ; 
global $user ; 
$user_center = $user->centerdetails ; 



	


echo drupal_get_form('joury_report_staff_attendance_form') ; 


if (!empty($_SESSION['employeeid']) && !empty($_SESSION['month']) && !empty($_SESSION['year']) ){
	$weeks_array = array(1=> "Saturday", 2=> "Sunday", 3=> "Monday" ,4=> "Tuesday" ,5=> "Wednesday", 6=> "Thursday", 7 => "Friday" ) ; 
	$employeeid = $_SESSION['employeeid'] ; 
	$year = $_SESSION['year'] ;  
	$month = $_SESSION['month'] ; 
	$number_of_days_per_month =  cal_days_in_month(CAL_GREGORIAN, $month, $year);
	$weekdays = array() ;  

	$staff_data_obj = _get_staff_of_employeeid($employeeid) ; 
	for($m=1; $m <= $number_of_days_per_month ; $m++) {
	 $daydate = date("l" , strtotime($month."/".$m."/".$year)) ; 
    if(!empty($staff_data_obj) &&  $daydate == $weeks_array[$staff_data_obj->weekend] ) {
    	$weekdays[$m] = $m ; 
    }	  	
	}	
	if(user_access("override centers division")){
		$attend_handler = db_query("select * from {joury_staff_attendance} where `transaction` = 7 and `employee_id` = %d and `month` = %d and `year` = %d group by day",
		$employeeid, $month, $year);
	}else{
		$attend_handler = db_query("select * from {joury_staff_attendance} where `center` = '%s' and  `transaction` = 7 and `employee_id` = %d and `month` = %d and `year` = %d group by day",
		$user_center, $employeeid, $month, $year);		
	}	 
	while($attend_obj = db_fetch_object($attend_handler) ) {
	$time[$attend_obj->day]['center'] = $attend_obj->center ;  	
	$time[$attend_obj->day]['attend_time'] = $attend_obj->time ; 
	}
	if(user_access("override centers division")){
		$leave_handler = db_query("select * from {joury_staff_attendance} where `transaction` = 8 and `employee_id` = %d and `month` = %d and `year` = %d group by day",
		$employeeid, $month, $year); 
	}else{
		$leave_handler = db_query("select * from {joury_staff_attendance} where `center` = '%s' and `transaction` = 8 and `employee_id` = %d and `month` = %d and `year` = %d group by day",
		$user_center, $employeeid, $month, $year); 	
	}	 	
	

	while($attend_obj = db_fetch_object($leave_handler) ) {
	$time[$attend_obj->day]['leave_time'] = $attend_obj->time ; 
	}



		if(count($time) == 0){		
			echo "<div class='messag error'><center>NO DATA</center></div>" ; 
		}else{
			echo "<a href='#' id='printer-link' ><img src='$printimg_url' width='30'/></a>" ; 
			echo "<table id='staff-report-table' > " ;
				echo "<tr>" ; 
				
					echo "<td  id='head-row'>" ;
						echo "STORE" ; 
					echo "</td>" ;
					
					echo "<td id='head-row'>" ;
						echo "DAY" ; 					
					echo "</td>" ; 
					
					echo "<td id='head-row'>" ;
						echo "CLOCK-IN" ; 	
					echo "</td>" ; 
										
					echo "<td id='head-row'>" ;
						echo "CLOCK-OUT" ; 	
					echo "</td>" ;  

					echo "<td id='head-row'>" ;
						echo "WORKING HOURS" ; 	
					echo "</td>" ; 					
															
				echo "</tr>" ; 
				
				for($k=1 ; $k<= $number_of_days_per_month ; $k++){ // printing each day
				echo "<tr>" ; 
				 if(!empty($time[$k])) { // if the day is exist in the database
					echo "<td>" ;
						echo $time[$k]['center'] ; 	 
					echo "</td>" ;
					
					echo "<td>" ;
						echo $k ; 	// lets print the day		
					echo "</td>" ; 
					
					
					static $totallag = 0 ; 
					echo "<td>" ;
					if(!empty($staff_data_obj)) { // if the user exist then print the data in details
						
						if(!empty($time[$k]['attend_time'])) { // the attend time for staff exist in the database
						
							$attendtime = date("H:i", strtotime($time[$k]['attend_time']));   
							$originaltime = $staff_data_obj->attend_time ; 
							$attendtime2 = (int) str_replace(":","",$attendtime); 
							$originaltime2 = (int) str_replace(":","",$originaltime); 

							if($attendtime2<$originaltime2) {
								$attendtimeinsec = (int) strtotime($month."/".$k."/".$year." ".$attendtime);
								$originaltimeinsec = (int) strtotime($month."/".$k."/".$year." ".$originaltime);
								if($attendtimeinsec >= ($originaltimeinsec - (30 * 60))){
									$attend_hr = $attendtime ;	
								}else{	
									$attend_hr = date("H:i", ($originaltimeinsec - (30 * 60)) ) ; 
								}	
							}else{
								$attend_hr = $attendtime  ; 
							}
							
							echo $time[$k]['attend_time'] ; 			
						}else {
							$attend_hr = '' ; 
							echo "<span class='error' > NO SIGN-IN </span>" ; 	
						}
						
					}else{
						// user not exist  :  lets calculate the working hours
						if(!empty($time[$k]['attend_time']) && !empty($time[$k]['leave_time'])) { // calculate the working hourse
							$attendtime = $month."/".$k."/".$year." ".$time[$k]['attend_time'] ; 
							$leavetime  = $month."/".$k."/".$year." ".$time[$k]['leave_time'] ;
						/*	$now = new DateTime($leavetime);
							$ref = new DateTime($attendtime);
							$guest_diff  = $now->diff($ref);
							$guest_working_hr = $guest_diff ->h.":".$guest_diff ->i ; */
							$now = strtotime($leavetime) ; 	
							$ref = strtotime($attendtime) ;
							$guest_diff = $now - $ref ;  
							$guest_working_hr = 	gmdate('h:i', $guest_diff );			
							
						}else{
							$guest_working_hr = "NOT DEFINED" ; 	
						}
							
						if(!empty($time[$k]['attend_time'])) {
							echo $time[$k]['attend_time'] ; 
						}else {
							echo "<span class='error' > NO SIGN-IN </span>" ; 	
						}											
					}		// end if : user not exist 				
					echo "</td>" ; 					
					
					echo "<td>" ;
					if(!empty($staff_data_obj)) {
						
						if(!empty($time[$k]['leave_time'])) { // the attend time for staff exist in the database
						
											
						
						
							$leavetime = date("H:i", strtotime($time[$k]['leave_time']));   
							$originaltime = $staff_data_obj->leave_time ; 
							$leavetime2 = (int) str_replace(":","",$leavetime); 
							$originaltime2 = (int) str_replace(":","",$originaltime); 

							if($leavetime2<$originaltime2) {
								$leave_hr = $leavetime ;	
							}else{
								$leave_hr = $originaltime  ; 
							}
							
							echo $time[$k]['leave_time'] ; 			
						}else {
							$leave_hr = '' ; 
							echo "<span class='error' > NO SIGN-OUT </span>" ; 	
						}
						
					}else{
						
						// user not exist  :  lets calculate the working hours
						if(!empty($time[$k]['attend_time']) && !empty($time[$k]['leave_time'])) { // calculate the working hourse
							$attendtime = $month."/".$k."/".$year." ".$time[$k]['attend_time'] ; 
							$leavetime  = $month."/".$k."/".$year." ".$time[$k]['leave_time'] ;
					/*		$now = new DateTime($leavetime);
							$ref = new DateTime($attendtime);
							$guest_diff = $now->diff($ref);
							$guest_working_hr = $guest_diff ->h.":".$guest_diff ->i ; */
							
							$now = strtotime($leavetime) ; 	
							$ref = strtotime($attendtime) ;
							$guest_diff = $now - $ref ;  
							$guest_working_hr = 	gmdate('h:i', $guest_diff );		
						}else{
							$guest_working_hr = "NOT DEFINED" ; 	
						}
						
						if(!empty($time[$k]['leave_time'])) {
							echo $time[$k]['leave_time'] ; 
						}else {
							echo "<span class='error' > NO SIGN-OUT </span>" ; 	
						}											
					}
					echo "</td>" ;  
					
					echo "<td>" ; 
					if(!empty($staff_data_obj)) {
						if(!empty($leave_hr) && !empty($attend_hr)){
							$staff_now_time = $month."/".$k."/".$year." ".$staff_data_obj->leave_time ; 
							$staff_ref_time = $month."/".$k."/".$year." ".$staff_data_obj->attend_time ;
							$staff_attend_time = $month."/".$k."/".$year." ".$time[$k]['attend_time'] ; 
							$staff_leave_time = $month."/".$k."/".$year." ".$time[$k]['leave_time'] ;
							
							/*
							$staff_original_now = new DateTime($staff_now_time);
							$staff_original_ref = new DateTime($staff_ref_time);
							$original_working_hr_obj = $staff_original_now->diff($staff_original_ref) ; 
							$original_working_hr = (int) $original_working_hr_obj->h.$original_working_hr_obj->i ; */
							
							$staff_original_now = strtotime($staff_now_time);
							$staff_original_ref = strtotime($staff_ref_time);
							$original_working_hr_obj = $staff_original_now  - $staff_original_ref ;
							$original_working_hr = (int) date("Hi",$original_working_hr_obj )  ; 
							
							/*
							$staff_now = new DateTime($staff_leave_time);
							$staff_ref = new DateTime($staff_attend_time);
							$staff_diff = $staff_now->diff($staff_ref) ;  */
							
							$staff_now = strtotime($staff_leave_time);
							$staff_ref = strtotime($staff_attend_time);
							$staff_diff = $staff_now - $staff_ref   ;							
							

							if((int) str_replace(":","",$attend_hr) > (int) str_replace(":","",$staff_data_obj->attend_time)){
								$staff_late_now = (int) strtotime($month."/".$k."/".$year." ".$attend_hr);
								$staff_late_ref = (int) strtotime($month."/".$k."/".$year." ".$staff_data_obj->attend_time);
								$late_time = ( $staff_late_now -  $staff_late_ref ) / 60 ; 
								
								$late = " Late ".$late_time."  m" ; 
							}
								
						/*	$she_worked = (int)	($staff_diff->h.$staff_diff->i) ;  */
							$she_worked = (int) gmdate("hi",$staff_diff ) ; 
							if($she_worked < $original_working_hr){
								$early = " Early " ;
							}
									
							/*echo $staff_diff->h.":".$staff_diff->i." h" ;	*/
							echo gmdate("h:i", $staff_diff) ;
							 
							echo !empty($late) ? "<div class='message error'>(".$late.")</div>"  : null  ;
							echo !empty($early) ? "<div class='message error'>(".$early.")</div>"  : null  ;
							$late = '' ; 
							$early = '' ; 
						}else{	
							echo "<div> NOT DEFINED </div>" ; 
						}
					}else{
						if(gmdate("h", $guest_diff) < 8){
							echo "{$guest_working_hr} <span style='color:red;'  > (Early) </span>" ;
						}else{
							echo "{$guest_working_hr}" ;
						}		
					}		
					echo "</td>" ; 
					

					}else{ // the day is not exist check if he is absent or its his weekend
					if(!in_array($k, $weekdays)) {	// if he is not in the weekend then print absent
					echo "<td>" ;
						echo "-" ; 	 
					echo "</td>" ;
					
					echo "<td>" ;
						echo $k ; 				
					echo "</td>" ; 
					
					echo "<td colspan='3' >" ;
						echo "<div class='message error' ><center>ABSENT</center></div>"; 				
					echo "</td>" ; 					

												
					}else{ 	// end if : if he is not in the weekend then print absent
								// ooh sorry he is in weekend
					echo "<td>" ;
						echo "-" ; 	 
					echo "</td>" ;
					
					echo "<td>" ;
						echo $k ; 				
					echo "</td>" ; 
					
					echo "<td colspan='3' >" ;
						echo "<div class='message ok' ><center>WEEK END</center></div>"; 				
					echo "</td>" ; 																	
					}	// end of : ooh sorry he is in weekend				
					}	// end if : the day is not exist check if he is absent or its his weekend		
				echo "</tr>" ; 						
				} // end if printing each day row
						
			echo "</table>" ; 			
		}		
	
	
	

	
	unset($_SESSION['employeeid']) ; 
	unset($_SESSION['month']) ; 
	unset($_SESSION['year']) ; 

}