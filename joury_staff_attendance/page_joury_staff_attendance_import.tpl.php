<?php
// $Id$
$module_path = drupal_get_path('module' , 'joury_staff_attendance') ; 
drupal_add_js($module_path."/js/script.js") ; 
drupal_add_js(array('modulePath' => url($module_path, array('absolute' => TRUE)) ), 'setting') ; 

echo drupal_get_form('_form_joury_staff_attendance_import') ; 