<?php
// $Id$

/**
* @tablename 
* - the table that we will represent information from
* @fieldsarray
* - array of fields that contain the fields we want to represent in the page
* @searchdata
* - hold the search form information
* 		- $searchdata['tablename'] : the tablename that we are going to search for result for
*		- $searchdata['fields'] :  array of fields that we are going to make form for
* @jslink
* - javascript url link for each page
* @options
* - html that containt option for each row if exist...if not options = ''
*/

$module_path = drupal_get_path('module' , 'joury_showroom') ; 
$siteurl = url('', array('absolute' => TRUE)) ; 
$numberofcolumns = count($fieldsarray) ; 

drupal_add_js($module_path."/jquery-1.4.3.min.js") ;
drupal_add_js($module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_js($module_path."/js/jquery-ui-1.8.14.custom.min.js") ;

$combox_box_module_path = drupal_get_path('module' , 'joury_register_service') ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcommon.js") ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcombo.js") ; 
drupal_add_css($combox_box_module_path."/codebase/dhtmlxcombo.css") ; 


drupal_add_js($module_path."/js/script.js") ;
drupal_add_css($module_path."/smoothness/jquery-ui-1.8.14.custom.css") ;
drupal_add_css($module_path."/fancybox/jquery.fancybox-1.3.4.css") ;
$url = drupal_get_path('module' , 'joury_api') ; 
$url_suppliers = drupal_get_path('module' , 'joury_suppliers') ; 
//drupal_add_js($url."/jquery.min.js") ;
$frontpage = url('',array('absolute' => TRUE)) ; 
drupal_add_css($url."/joury_api.css") ;
drupal_add_js($jslink) ;  

drupal_add_css($url_suppliers."/joury_suppliers.css") ;

drupal_add_js(array('frontpage' => $frontpage), 'setting') ; 
drupal_add_js(array('numberofcolumns' => $numberofcolumns), 'setting') ; 
$data = _arrayofobject_data($tablename) ; 
$num_of_columns = count($fieldsarray) ; 
$num_of_rows = count($data) ; 




//dynamic search form 
if(count($searchdata) != 0){ // if the hook implementation pass search variable then do the following
	echo "<table id='jouryspa-page-view-search-table'> " ;
	echo "<form id='jouryspa-page-view-search-form' method='post' action='' > ";  
		echo "<input type='hidden' value='{$searchdata['tablename']}' name='table' />" ; 
	foreach($searchdata['fields'] as $key => $val){
			
			echo "<input type='hidden' value='{$key}' name='field-{$key}' />" ; 
			 echo "<tr>" ;
			 
			 		echo "<td>" ; 
			 			echo "<label>".$val." : </label>" ; 
				 	echo "</td>" ; 
				 	
				 	echo "<td>" ; 
			 			echo "<input type='text' name='searchinput-{$key}' /> " ; 
				 	echo "</td>" ; 
				 	
			 	
			 echo "</tr>" ;  
 			
		
		}
			echo "<tr>" ;					
					echo "<td>" ; 
			 			echo "<input type='submit' name='searchsubmit' value='search' /> " ; 
				 	echo "</td>" ; 	
			echo "</tr>" ;  	 	
	echo "</form>" ; 
	echo "</table>" ; 

}




//default view of users
if(empty($_POST['searchsubmit'])){
echo "<div id='jouryspa-page-table-container' > " ; 
echo "<table id='jouryspa-page-table'>"  ; 
echo "<tr id='jouryspa-page-view-head-row'>" ; // print first row that include tha head title of rows
foreach($fieldsarray as $key => $val) { // print each column in the first row
		echo "<td>";
			echo $val ; 
		echo "</td>";
}
if ($options != ''){
		echo "<td>";
			echo 'OPTIONS' ; 
		echo "</td>";	
}	
echo "</tr>" ; 


//for($k=0 ; $k<$num_of_rows ; $k++){
	echo "<tr id='jouryspa-page-view-row' >" ; // printing each row	
		foreach ($fieldsarray as $key => $val) {
		echo "<td id='jouryspa-page-view-column' >";
			$fieldlabel =  $val ; // print field name
			$optionsarray[''] = '' ; 
			for($k=0 ; $k<$num_of_rows ; $k++){
				$nodeid = $data[$k]->nid ; 
				$fieldvalue = substr($data[$k]->$key,0,20) ;//$k point to the user itself... and $key point to the user field name
				$optionsarray[$nodeid] = $fieldvalue ; 
			}	
		echo 	drupal_get_form('jouryapi_form_select',$optionsarray,str_replace(" ","",$fieldlabel)) ; 
		echo "</td>";
		}
		if ($options != ''){
		echo "<td>";
			echo $options ; 
		echo "</td>";	
		}			
	echo "</tr>" ; // the end of each row
//}
echo "</table>" ; 
echo "</div>" ; 
}





//when somebody search for something
if(!empty($_POST['searchsubmit'])){
		foreach($_POST as $key => $val){
			if(substr($key,0,6) == 'field-'){
				$fields[] = $val ; 	
			}
			if(substr($key,0,12) == 'searchinput-'){
				$input[] = $val ; 	
			}
			if($key == 'table'){
				$table = $val ; 	
			}		
		} 
		
		$search_data = _get_data_with_multi_conditions($table,$fields,$input) ; 
		if(count($search_data) ==  0 ){
			drupal_set_message("<div class='message warning'> No result found please try another keywords..!! </div>") ;
			$arg0 = arg(0) ; 
			$arg1 = arg(1) ; 
			drupal_goto($arg0."/".$arg1)  ; 	
			
		}	
		echo "<table id='jouryspa-page-table'>"  ; 

		echo "<tr id='jouryspa-page-view-head-row'>" ; // print first row that include tha head title of rows
			foreach($fieldsarray as $key => $val) {  // print each column in the first row
				echo "<td>";
					echo $val ; 
				echo "</td>";
			}
			if ($options != ''){
				echo "<td>";
					echo 'OPTIONS' ; 
				echo "</td>";	
			}	
		echo "</tr>" ; 


		for($k=0 ; $k<$num_of_rows ; $k++){
			echo "<tr id='jouryspa-page-view-row' >" ; // printing each row	
				foreach($fieldsarray as $key => $val) {
					if(!empty($search_data[$k]->$key)){
					echo "<td id='jouryspa-page-view-column'  >";
						echo l($search_data[$k]->$key,'node/'.$search_data[$k]->nid) ; //$k point to the user itself... and $key point to the user field name
					echo "</td>";
					}
				}
				if ($options != ''){
					echo "<td>";
						echo $options ; 
					echo "</td>";	
				}	
			echo "</tr>" ; // the end of each row
		}
		echo "</table>" ; 	
		
}	