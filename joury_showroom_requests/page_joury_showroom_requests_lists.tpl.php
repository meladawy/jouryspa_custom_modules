<?php
// $Id$
$module_path =  drupal_get_path('module' , 'joury_showroom_requests') ; 
$current_module_path = drupal_get_path('module' , 'joury_showroom_requests') ; 
$siteurl = url('', array('absolute' => TRUE)) ; 
$requests = _get_showroom_requests() ; 
$number_of_requests =  count($requests) ; 
drupal_add_js( array('url' => $siteurl) , 'setting') ; 
drupal_add_js($current_module_path."/jquery-1.4.3.min.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_css($current_module_path."/fancybox/jquery.fancybox-1.3.4.css") ;
drupal_add_css($module_path."/joury_showroom_requests.css") ; 
drupal_add_js($module_path."/joury_showroom_requests.js") ; 

if($number_of_requests > 0){
echo "<center>" ; 
echo "<table id='page-showroom-table'>" ; 
	echo "<tr id='page-showroom-table-row-head'>" ; 
	
		echo "<td>" ; 
			echo "REQUEST ID" ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo "SHOWROOM" ; 
		echo "</td>" ;
		

		echo "<td>" ; 
			echo "PRODUCT" ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo "QUANTITY" ; 
		echo "</td>" ; 		
		
		echo "<td>" ; 
			echo "BY" ; 
		echo "</td>" ; 	
						
		echo "<td>" ; 
			echo "DATE" ; 
		echo "</td>" ; 	
						
		echo "<td>" ; 
			echo "OPTIONS" ; 
		echo "</td>" ; 
		
	echo "</tr>" ; 

for($k=0 ; $k < $number_of_requests ; $k++ ){
	if($requests[$k]->quantity > 0){
	echo "<tr>" ; 	
	
		echo "<td>" ; 
			echo $requests[$k]->id  ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo $requests[$k]->showroomname  ; 
		echo "</td>" ; 
		
					
		echo "<td>" ; 
			echo $requests[$k]->productname  ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo $requests[$k]->quantity  ; 
		echo "</td>" ; 		
						
		echo "<td>" ; 
			echo $requests[$k]->author  ; 
		echo "</td>" ; 	
						
		echo "<td>" ; 
			echo $requests[$k]->date  ; 
		echo "</td>" ; 
		
						
		echo "<td>" ; 
			echo  "<br/><a href='{$siteurl}'  id='done' />DONE</a>"  ; 
		echo "</td>" ; 		
	echo "</tr>" ; 
	}
		if($_POST['requestremoveid']){
			db_query("update `joury_showoom_requests` set `status`=1  where `id` = %d" ,$_POST['requestremoveid'])	 ; 
		}	
	
}	



echo "</table>" ; 
echo "</center>" ;
}else{
echo "<center> NO REQUESTS.. </center>" ;	
}	 