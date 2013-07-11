<?php
// $Id$
$module_path = drupal_get_path('module' , 'joury_register_service') ;
$url = url('',array('absolute' => TRUE));
drupal_add_js($module_path."/jquery-1.6.1.min.js") ;  
drupal_add_js($module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_css($module_path."/fancybox/jquery.fancybox-1.3.4.css") ;
drupal_add_js($module_path."/js/jquery-ui-1.8.14.custom.min.js") ;
drupal_add_css($module_path."/smoothness/jquery-ui-1.8.14.custom.css") ;
drupal_add_js($module_path."/js/jquery-ui-timepicker-addon.js") ;


$combox_box_module_path = drupal_get_path('module' , 'joury_register_service') ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcommon.js") ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcombo.js") ; 
drupal_add_css($combox_box_module_path."/codebase/dhtmlxcombo.css") ; 

drupal_add_js($module_path."/home_page.js") ;  
drupal_add_css($module_path."/home_page.css") ;  
drupal_add_js( array('frontpage' => $url) , 'setting') ; 



echo drupal_get_form('joury_register_service_client_form_home'); 



