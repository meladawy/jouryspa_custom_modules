<?php
// $Id$
$current_module_path = drupal_get_path('module' , 'joury_suppliers') ; 
$siteurl = url('', array('absolute' => TRUE)) ; 
drupal_add_js($current_module_path."/jquery-1.4.3.min.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_css($current_module_path."/fancybox/jquery.fancybox-1.3.4.css") ;

$combox_box_module_path = drupal_get_path('module' , 'joury_register_service') ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcommon.js") ; 
drupal_add_js($combox_box_module_path."/codebase/dhtmlxcombo.js") ; 
drupal_add_css($combox_box_module_path."/codebase/dhtmlxcombo.css") ; 


drupal_add_js($current_module_path."/joury_suppliers2.js") ;
drupal_add_css($current_module_path."/joury_suppliers.css") ;



drupal_add_js(array('url' => $siteurl) , 'setting'  ); 
$number_of_stores =  count($stores) ; 
$ajax = url('ajax/store/products/',array('absolute' => TRUE)) ;

echo drupal_get_form('_get_supplier_form') ; 
