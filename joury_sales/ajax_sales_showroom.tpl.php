<?php
// $Id$

$showroomid = arg(4) ; 

	$showroomid = _sqlInject($showroomid) ; 
	$products = _get_showroom_products($showroomid) ; 
	$number_of_products = count($products) ; 
	if($number_of_products == 0 ){
		echo "NO PRODUCTS IN THIS showroom" ; 
		return ;	
	}
	echo "<form method='post' action='' >" ;
echo "<table id='ajax-sales-showroom-table'>" ; 
echo "<tr >" ; 
	echo "<td colspan='4'>" ; 
		_print_select_input_type_clients('clientid','joury_clients','firstname','cid','') ; 
	echo "</td>" ;
	echo "<td colspan='3'>" ; 
		$timestamp = time() ; 
		$date = date("m/d/Y h:i a", $timestamp);
		echo "<input type='text' name='dateee' id='dateee' value='{$date}'  />" ;  
	echo "</td>" ;
echo "</tr>" ; 
echo "<tr id='joury-showroom-products-head-row'>" ; 
	echo "<td id='joury-showroom-products-head-column' >PRODUCT ID</td>" ;
	echo "<td id='joury-showroom-products-head-column' >PRODUCT NAME</td>" ; 
	echo "<td id='joury-showroom-products-head-column' >EXIST QUANTITY</td>" ; 
//	echo "<td id='joury-showroom-products-head-column' >STOCK PRICE</td>" ; 
	echo "<td id='joury-showroom-products-head-column' >SELLING PRICE</td>" ; 	
	echo "<td id='joury-showroom-products-head-column' >QUANTITY</td>" ; 			
	echo "<td id='joury-showroom-products-head-column' >SELECT</td>" ; 	
echo "</tr>" ; 
for($k=0 ; $k<$number_of_products ;  $k++){
	$rate = _get_rate_of_product($products[$k]->productid) ;
	$selling_price = (($products[$k]->price) + ((( $products[$k]->price) / 100 ) * $rate) ) ;
	$product_static_price = _get_product_static_price($products[$k]->productid) ; 
	$selling_price = !empty($product_static_price) ? $product_static_price : $selling_price ; 
echo "<tr>" ; 
	echo "<td>".$products[$k]->productid."</td>" ;
	echo "<td>".$products[$k]->productname."</td>" ;
	echo "<td>".$products[$k]->quantity."</td>" ;
	//echo "<td>".$products[$k]->price."</td>" ;
	echo "<td>".$selling_price."</td>" ;
	echo "<td> <input type='text' size='5' id='quantity' name='quantity-".$products[$k]->productid."' value='1' disabled='' style='background:#BDBDBD' /></td>" ; 			
	echo "<td><input type='checkbox' id='select' name='select-".$products[$k]->productid."' /></td>" ; 	
	echo "<input type='hidden' id='sellprice' name='sellprice-".$products[$k]->productid."'  value='{$selling_price}'/>" ;
	echo "<input type='hidden' id='price' name='price-".$products[$k]->productid."' value='".$products[$k]->price."' />" ; 	 	
echo "</tr>" ; 	
	}	
	echo "<input type='hidden' id='showroomid' name='showroomid' value='{$showroomid}' />" ; 
	
	echo "<tr >" ; 
	echo "<td colspan='7'>" ; 
		echo "<input type='submit' value='save' name='sales-save'  id='sales-save' />" ; 
	echo "</td>" ;
	echo "</tr>" ; 
	
echo "</table>" ; 


echo "</form>" ; 