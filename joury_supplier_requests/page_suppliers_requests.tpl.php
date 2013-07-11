<?php
// $Id$
$module_path =  drupal_get_path('module' , 'joury_supplier_requests') ; 
$siteurl = url('', array('absolute' => TRUE)) ; 
$requests = _get_suppliers_requests() ; 
$number_of_requests =  count($requests) ; 
drupal_add_js( array('url' => $siteurl) , 'setting') ; 
drupal_add_css($module_path."/joury_supplier_requests.css") ; 
drupal_add_js($module_path."/jquery-1.4.3.min.js") ; 
drupal_add_js($module_path."/joury_supplier_requests.js") ; 

if($number_of_requests > 0){
echo "<center>" ; 
echo "<table id='page-suppliers-table'>" ; 
	echo "<tr id='page-suppliers-table-row-head'>" ; 
	
		echo "<td>" ; 
			echo "ORDER ID" ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo "SUPPLIER" ; 
		echo "</td>" ; 
					
		echo "<td>" ; 
			echo "PRODUCT" ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo "QUANTITY" ; 
		echo "</td>" ; 		
						
		echo "<td>" ; 
			echo "ITEM PRICE" ; 
		echo "</td>" ; 	
						
		echo "<td>" ; 
			echo "TOTAL PRICE" ; 
		echo "</td>" ; 

		echo "<td>" ; 
			echo "DATE" ; 
		echo "</td>" ; 

		echo "<td>" ; 
			echo "BY" ; 
		echo "</td>" ; 				
						
		echo "<td>" ; 
			echo "OPTIONS" ; 
		echo "</td>" ; 
		
	echo "</tr>" ; 

for($k=0 ; $k < $number_of_requests ; $k++ ){
	if($requests[$k]->quantity > 0 && $requests[$k]->nettotalad > 0 && $requests[$k]->itempricead > 0){
	echo "<tr>" ; 	
	
		echo "<td>" ; 
			echo $requests[$k]->id  ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo $requests[$k]->suppliername  ; 
		echo "</td>" ; 
					
		echo "<td>" ; 
			echo $requests[$k]->productname  ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo $requests[$k]->quantity  ; 
		echo "</td>" ; 		
						
		echo "<td>" ; 
			echo $requests[$k]->itempricead  ; 
		echo "</td>" ; 	
						
		echo "<td>" ; 
			echo $requests[$k]->nettotalad  ; 
		echo "</td>" ; 
		
		echo "<td>" ; 
			echo $requests[$k]->date  ; 
		echo "</td>" ; 
		
		echo "<td>" ; 
			echo $requests[$k]->author  ; 
		echo "</td>" ; 
						
		echo "<td>" ; 
			echo  "<input type='submit' value='OPERATION' id='operation'  />"  ; 
		echo "</td>" ; 		
	echo "</tr>" ; 
	}else{
		if($requests[$k]->quantity == 0 || $requests[$k]->nettotalad == 0){
			db_query("delete from `joury_requests_from_suppliers`  where `id` = %d" ,$requests[$k]->id )	 ; 
		}	
	}	
}	



echo "</table>" ; 
echo "</center>" ;
}else{
echo "<center> NO REQUESTS.. </center>" ;	
}	 