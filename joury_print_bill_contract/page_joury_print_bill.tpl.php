<?php
// $Id$
$current_module_path = drupal_get_path('module' , 'joury_bill') ; 
$siteurl = url('', array('absolute' => TRUE)) ; 
drupal_add_js($current_module_path."/jquery-1.4.3.min.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.mousewheel-3.0.4.pack.js") ;
drupal_add_js($current_module_path."/fancybox/jquery.fancybox-1.3.4.pack.js") ;
drupal_add_js($current_module_path."/js/jquery-ui-1.8.14.custom.min.js") ;
drupal_add_css($current_module_path."/smoothness/jquery-ui-1.8.14.custom.css") ;
drupal_add_css($current_module_path."/fancybox/jquery.fancybox-1.3.4.css") ;
drupal_add_css($current_module_path."/jourybill.css") ;
drupal_add_css($current_module_path."/jourybill.css" , $type = 'module', $media = 'screen') ; 
$printimg_url = url($current_module_path."/print.gif", array('absoluter' => TRUE)) ;  
drupal_add_js($current_module_path."/jquery.printElement.js") ;
drupal_add_js($current_module_path."/joury_bill_process.js") ;
drupal_add_js(array('url' => $siteurl) , 'setting'  ); 




$arg3 = arg(3) ; 

if(!empty($arg3)) {
$bills = _get_bills_of_primarybill($arg3) ; 
$bills_array = explode(" , ",$bills);
$bills = array() ; 
foreach($bills_array as $value) {
	if($value != ''){
		$bills[] = $value ; 	
	}		
}
$primary_bill_data = _get_primary_bill_data($arg3) ; 


	foreach($bills as $bid){
		$bill_data[] = _get_bill_data($bid) ; 	
	}
	$clientid = $bill_data[0][0]->clientid ; 
	$staffid = $bill_data[0][0]->staffid ; 
	$allprice = 0 ; 
	$clientname = _get_client_name($clientid) ; 
	$cashier = $bill_data[0][0]->cashier ; 
	$shopname = @variable_get('site_name') ; 
	$bils_id = '' ; 
	foreach($bill_data as $billdata){
			$totalprice =  $billdata[0]->totalprice ; 
	}
	echo "<center><table id='ajax-bill-client2'  cellspacing='10'>" ; 
	
	echo "<tr>";
		echo "<td id='print-row'>" ; 
			echo "<a href='#' id='printer-link' ><img src='$printimg_url' width='30'/></a>" ; 
		echo "</td>" ; 	
	echo "</tr>" ;	
	
	echo "<tr>" ; 
		echo "<td colspan='2' style='text-align:center;'></td>" ; 
		echo "<td colspan='2' style='text-align:center;'>".$primary_bill_data->date."</td>" ; 
	echo "</tr>" ;	
	
	echo "<tr>" ; 
		echo "<td colspan='4' style='text-align:center;'><strong>".$shopname."</strong></td>" ; 
	echo "</tr>" ;	
		
	echo "<tr>" ; 
			echo "<td colspan='4' style='text-align:center;'>".KUWAIT."</td>" ; 
	echo "</tr>" ;			
	
	echo "<tr>" ; 
			echo "<td colspan='2' style='text-align:left;'>".substr($primary_bill_data->date,0,12)."</td>" ; 
			echo "<td colspan='2' style='text-align:right;'><strong>Reciept:</strong>" ;
			echo $primary_bill_data->id;
		
			echo  "</td>" ; 
	echo "</tr>" ;		
	
		echo "<tr>" ; 
			echo "<td colspan='2' style='text-align:left;'>".substr($primary_bill_data->date,12,3242)."</td>" ; 
			$cashier_data = user_load($cashier)  ; 
			$center_name  = $cashier_data->centerdetails ; 
			echo "<td colspan='2' style='text-align:right;'><strong>Store:</strong>".$center_name."</td>" ; 
	echo "</tr>" ;		
	
	echo "<tr>" ; 
			echo "<td colspan='2' style='text-align:center;'></td>" ; 
			echo "<td colspan='2' style='text-align:right;'><strong>Cashier: </strong>".$cashier."</td>" ; 
	echo "</tr>" ;		
	
	echo "<tr>" ; 
	
			echo "<td colspan='4' style='text-align:left;'><strong>Bill to: </strong>".$clientname."</td>" ; 

	echo "</tr>" ;		
	
	
	echo "<tr>" ; 
		echo "<td id='label-text' style='text-align:center;'> ITEM </td>" ; 
		echo "<td id='label-text' style='text-align:center;'> QTY </td>" ; 
		echo "<td id='label-text' style='text-align:center;'> UNIT PRICE </td>" ; 
		echo "<td id='label-text' style='text-align:center;'> TOTAL </td>" ; 
	echo "</tr>" ;	 
	foreach($bill_data as $billdata){
		 
		
	if($billdata[0]->type == 'product'){
		$itemname = "<strong>PRODUCT: </strong> ".$billdata[0]->productname ; 	
	}elseif($billdata[0]->type == 'DEBT'){
		$itemname = "<strong>DEBT: </strong> ".$billdata[0]->servicename ; 
	}else{
		$itemname = "<strong>SERVICE: </strong> ".$billdata[0]->servicename ; 
	}			
		
		
		
	echo "<tr>" ; 
		echo "<td style='text-align:center;'>".$itemname."</td>" ; 
		echo "<td style='text-align:center;'>".$billdata[0]->quantity."</td>" ; 
		echo "<td style='text-align:center;'>".$billdata[0]->sellprice."</td>" ; 
		echo "<td style='text-align:center;'>".$billdata[0]->totalprice."</td>" ; 
		echo "<input type='hidden' name='showroomid' id='showroomid' value='".$billdata[0]->showroomid."' />" ;
		echo "<input type='hidden' name='quantity' id='quantity' value='".$billdata[0]->quantity."' />" ;
		echo "<input type='hidden' name='productid' id='productid' value='".$billdata[0]->productid."' />" ;
	echo "</tr>" ;
	$allprice += $billdata[0]->totalprice ; 
	}
	echo "<tr>" ; 
		echo "<td colspan='4' ></td>" ; 
	echo "</tr>" ;	
	echo "<tr>" ; 
		echo "<td >-</td>" ; 
		echo "<td >-</td>" ; 
		echo "<td ><strong>TOTAL PRICE: </strong></td>" ; 
		echo "<td >".$allprice." <strong>KWD</strong> </td>" ; 
	echo "</tr>" ;	
	$discount = $billdata[0]->discount ; 
	if($discount != 0 ){		
		echo "<tr>" ; 
		echo "<td colspan='4'><strong>DISCOUNT:" ; 
		echo $discount ; 
		echo " % </td>" ; 
		}
	echo "</tr>" ;	

	echo "</table></center>" ; 
	
}