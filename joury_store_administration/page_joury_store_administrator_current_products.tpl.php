<?php
// $Id$
$products = _get_products_of_store_admin_content() ; 
$module_path =  drupal_get_path('module' , 'joury_store_administration') ; 
$siteurl = url('', array('absolute' => TRUE)) ; 
$current_page = $siteurl."/joury/store/admin/current/products" ; 
$number_of_products =  count($products) ; 
drupal_add_js( array('url' => $siteurl) , 'setting') ; 
drupal_add_css($module_path."/joury_store_admin_products.css") ; 
drupal_add_js($module_path."/jquery-1.4.3.min.js") ; 
drupal_add_js($module_path."/joury_store_admin_products.js") ; 
if(!empty($_POST['send']) && !empty($_POST['storeid'])){
	global $user ; 
	$timestamp = time() ; 
	$date = date("m/d/Y h:i a",$timestamp) ; 
	$storeid = $_POST['storeid'] ; 
	$storename = _get_store_name($storeid) ; 
	foreach($_POST as $key => $val){
		if($val == 'on'){
			$id = substr($key,7,2342);
			$productid_arr[] = $_POST['productid-'.$id] ; 
			$quantity_arr[] = $_POST['quantity-'.$id] ;
			$exist_quantity_arr[] = $_POST['exist-quantity-'.$id] ;
			$storeprice_arr[] = $_POST['storeprice-'.$id] ;
			$rawid_arr[] = $_POST['rawid-'.$id]  ; 
 		}
	}	// end of foreach
	$number_of_items =  count($productid_arr) ;

	for($m=0 ; $m < $number_of_items ;  $m++){
		$productid = (int)	$productid_arr[$m] ; 
		$exist_quantity = $exist_quantity_arr[$m] ; 
		$quantity = (int) $quantity_arr[$m] ; 
		$storeprice = (float) $storeprice_arr[$m] ;   
		$rawid = $rawid_arr[$m] ; 
		$new_total_price = $storeprice * $quantity ; 
		$productname  = _get_product_name($productid) ; 
		if((is_int($quantity) || is_float($quantity)) && (is_int($storeprice) || is_float($storeprice)) && $storeprice != 0 && $quantity != 0  ){				
									
				}else{
					drupal_set_message("<div class='message error'> BAD INPUT..!! </div>");		
					drupal_goto($current_page) ; 
					return ; 
				}
	
		if($quantity <= $exist_quantity ){


 				// first update current admin store
				db_query("update `joury_store_administration_content` set `quantity` = `quantity` - %d where `id` = %d" 
				, $quantity,$rawid) ; 
			 				
				
				// we delete the raw if the quantity = 0
				$quantity_after_update = _get_quantity_of_store_admin_rawid($rawid) ; 
				if ($quantity_after_update == 0){
					db_query("delete from `joury_store_administration_content` where `id` = %d" , $rawid) ; 
				}
				// now we are going to update the store that will receive the products
				if(_check_product_in_store($productid,$storeid)){
					echo "el product mawgooda wana da5alt fe el update operation" ; 
					$result_handle =  db_query("select * from `joury_store` where `productid` = %d and `storeid` = %d " ,$productid , $storeid ) ;
					$result = db_fetch_object($result_handle) ; 
					$old_quantity  =  $result->quantity ; 	
					$old_price  =  $result->price ;
					$old_total_price = ($old_price * $old_quantity) ; 
					$old_new_quantity =  ($old_quantity + $quantity) ; 			 
					$old_new_total_price =  $old_total_price 	+ $new_total_price ; 
					$old_new_unit_price = $old_new_total_price/$old_new_quantity ; 
					if((is_float($old_new_quantity) || is_int($old_new_quantity)) && (is_float($old_new_unit_price) || is_int($old_new_unit_price)) && $old_new_quantity != 0 &&  $old_new_unit_price != 0 ){ 
						db_query("update `joury_store` set `quantity` = %f , `price` = %f where storeid=%d and productid=%d ",$old_new_quantity ,$old_new_unit_price,$storeid,$productid )	 ; 	
				
					// insert into store logs {joury_log_store_imports}	
						db_query("insert into {joury_log_store_imports} (`storeid` , `productid`,`quantity`, `price`, `storename` , `productname`,`author`,`date`) values (%d,%d,%f,%f,'%s','%s','%s','%s') " ,$storeid,$productid,$quantity,$storeprice,$storename,$productname,$user->name,$date ) ;  						
					}
				}else{
					$storename = _get_store_name($storeid) ; 
					$productname = _get_product_name($productid);
					db_query("insert into `joury_store` (`storeid` , `productid`,`quantity`, `price`, `storename` , `productname`) values (%d,%d,%f,%f,'%s','%s') " ,$storeid,$productid,$quantity,$storeprice,$storename,$productname ) ;  	
					
					
					// insert into store logs {joury_log_store_imports}	
					db_query("insert into {joury_log_store_imports} (`storeid` , `productid`,`quantity`, `price`, `storename` , `productname`,`author`,`date`) values (%d,%d,%f,%f,'%s','%s','%s','%s') " ,$storeid,$productid,$quantity,$storeprice,$storename,$productname,$user->name,$date ) ;  		
		 		}
			}else{ // make sure that the required quantity is less that the exist quantity
				drupal_set_message("<div class='message error'> TOO MUCH QUANTITY..!! </div>");	
			}	// else of make sure that the required quantity is less that the exist quantity
					
		} // make the operation on each 
		drupal_goto($current_page) ; 
}	// make sure that the post is sent




if($number_of_products ==  0){
	echo "<center>NO PRODUCTS</center>" ; 	
}else{	
echo "<center>" ; 
echo "<form method='POST' action='' >" ; 
echo "<table id='dynamic-table-content'  style='display:none;'   >" ;  //

echo "<tr id='page-store-admin-table-row-head'>" ; 
	
		echo "<td>" ; 
			echo "PRODUCT ID" ; 
		echo "</td>" ; 
		
				
		echo "<td>" ; 
			echo "PRODUCT NAME" ; 
		echo "</td>" ; 
					
		echo "<td>" ; 
			echo "QUANTITY" ; 
		echo "</td>" ; 
				
						
		echo "<td>" ; 
			echo "STORE PRICE" ; 
		echo "</td>" ; 	
						
		echo "<td>" ; 
			echo "SELL PRICE (RATE)" ; 
		echo "</td>" ; 	
				
		echo "<td>" ; 
			echo "quantity" ; 
		echo "</td>" ; 	
					
		echo "<td>" ; 
			echo "OPTION" ; 
		echo "</td>" ; 
		
	echo "</tr>" ; 
	

echo "</table> " ; 
echo "<table>" ; 
	echo "<tr>" ; 
		echo "<td>" ; 
			_print_select_input_type('storeid','joury_stores','name','sid','select-store') ; 
		echo "</td>" ; 
		
		echo "<td>" ;
		echo "<strong> SEARCH :</strong>" ; 
		echo "<input type='text'  name='search' id='search'/>" ;
		echo "</td>" ; 
		
		echo "<td>" ; 
			 echo "<input type='submit' name='send' id='send' value='CASH TO STORE' disabled='' />" ;
		echo "</td>" ; 
	
	echo "</tr>" ; 
echo "</table>" ; 

echo "<table id='page-store-admin-table'>" ; 
	
	
	echo "<tr id='page-store-admin-table-row-head'>" ; 
	
		echo "<td>" ; 
			echo "PRODUCT ID" ; 
		echo "</td>" ; 
		
				
		echo "<td>" ; 
			echo "PRODUCT NAME" ; 
		echo "</td>" ; 
					
		echo "<td>" ; 
			echo "QUANTITY" ; 
		echo "</td>" ; 
				
						
		echo "<td>" ; 
			echo "STORE PRICE" ; 
		echo "</td>" ; 	
						
		echo "<td>" ; 
			echo "SELL PRICE" ; 
		echo "</td>" ; 	
				
		echo "<td>" ; 
			echo "quantity" ; 
		echo "</td>" ; 	
					
		echo "<td>" ; 
			echo "OPTION" ; 
		echo "</td>" ; 
		
	echo "</tr>" ; 
echo "</table>"; 
echo "<table id='joury-admin-changable-table' >" ;
for($k=0 ; $k < $number_of_products ; $k++ ){
	$keynumber = rand(0,1000000000) ; 
	echo "<tr>" ; 
		echo "<td>" ; 
			echo $products[$k]->productid  ; 
		echo "</td>" ; 
		
		echo "<td>" ; 
			echo $products[$k]->productname  ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo $products[$k]->quantity  ; 
		echo "</td>" ; 
					
		echo "<td>" ; 
			echo $products[$k]->storeprice  ; 
		echo "</td>" ; 
				
		echo "<td>" ; 
			echo $products[$k]->sellprice  ; 
		echo "</td>" ; 	
			
		echo "<td >" ; 
			echo "<input type='text' size='7' name='quantity-".$k.$keynumber."' id='quantity' value='1'  disabled=''/>"   ; 
		echo "</td>" ; 
					
		echo "<td>" ;
			echo "<input type='checkbox' name='select-".$k.$keynumber."' id='select' />"   ; 
		echo "</td>" ; 		
		
		echo "<td style='display:none;' >" ; 
			echo "<input type='hidden' name='exist-quantity-".$k.$keynumber."' id='exist-quantity' value='".$products[$k]->quantity."' />"   ; 
			echo "<input type='hidden' name='storeprice-".$k.$keynumber."' id='storeprice' value='".$products[$k]->storeprice."' />"   ; 
			echo "<input type='hidden' name='rawid-".$k.$keynumber."' id='rawid' value='".$products[$k]->id."' />"   ; 
			echo "<input type='hidden' name='productid-".$k.$keynumber."' id='productid' value='".$products[$k]->productid."' />"   ; 
		echo "</td>" ; 
	echo "</tr>" ; 
}	


echo "</table>" ; 
echo "</form>" ;
echo "</center>" ; 

}