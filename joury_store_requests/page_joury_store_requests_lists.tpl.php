<?php
// $Id$
$module_path =  drupal_get_path('module' , 'joury_store_requests') ; 
$current_module_path = drupal_get_path('module' , 'joury_store_requests') ; 
$siteurl = url('', array('absolute' => TRUE)) ; 
$requests = _get_store_requests() ; 
$number_of_requests =  count($requests) ; 
drupal_add_js( array('url' => $siteurl) , 'setting') ; 
drupal_add_js($current_module_path."/jquery-1.4.3.min.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_css($current_module_path."/fancybox/jquery.fancybox-1.3.4.css") ;
drupal_add_css($module_path."/joury_store_requests.css") ; 
drupal_add_js($module_path."/joury_store_requests.js") ; 

if($number_of_requests > 0){
echo "<center>" ; 
echo "<table id='page-store-table'>" ; 
	echo "<tr id='page-store-table-row-head'>" ; 
	
		echo "<td>" ; 
			echo "REQUEST ID" ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo "STORE" ; 
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
			echo $requests[$k]->storename  ; 
		echo "</td>" ; 
					
		echo "<td>" ; 
			echo $requests[$k]->productname  ; 
		echo "</td>" ; 
		
		echo "<td style='display:none;' id='product-id'>" ; 
			echo $requests[$k]->productid  ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo $requests[$k]->quantity  ; 
		echo "</td>" ; 		
		
		echo "<td style='display:none;' id='store-id'>" ; 
			echo $requests[$k]->storeid  ; 
		echo "</td>" ; 
						
		echo "<td>" ; 
			echo $requests[$k]->author  ; 
		echo "</td>" ; 	
						
		echo "<td>" ; 
			echo $requests[$k]->date  ; 
		echo "</td>" ; 
		
						
		echo "<td style='padding-top:0px;'>" ; 
		//	echo  "<a href='{$siteurl}/joury/store/admin/current/products#ja-content-main'  id='products-manager' />PRODUCTS MANAGER</a>"  ; 
			echo  "<br/><a href='{$siteurl}' style='text-decoration:none; top: -21px; position:relative;'  id='p-m' />FROM PRODUCTS MANAGER</a>"  ; 
			echo  "<br/><a href='{$siteurl}' style='text-decoration:none; top: -15px; position:relative; '  id='a-s' />FROM ANOTHER STORE</a>"  ; 
			echo  "<br/><a href='{$siteurl}' style='text-decoration:none; top: -5px; position:relative; '  id='remove' />REMOVE</a>"  ; 
		echo "</td>" ; 		
	echo "</tr>" ; 
	}

	
}	



echo "</table>" ; 
echo "</center>" ;
}else{
echo "<center> NO REQUESTS.. </center>" ;	
}	 