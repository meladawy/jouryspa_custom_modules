<?php
// $Id$
$module_path = drupal_get_path('module' , 'joury_clients_attendance') ;
$url = url('',array('absolute' => TRUE));
drupal_add_js($module_path."/jquery-1.6.1.min.js") ;  

$combox_box_module_path = drupal_get_path('module' , 'joury_register_service') ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcommon.js") ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcombo.js") ; 
drupal_add_css($combox_box_module_path."/codebase/dhtmlxcombo.css") ; 

drupal_add_js($module_path."/all_clients_page.js") ;  
drupal_add_css($module_path."/all_clients_page.css") ;  
drupal_add_js( array('frontpage' => $url) , 'setting') ; 
	echo drupal_get_form('page_all_clients_form') ; 
