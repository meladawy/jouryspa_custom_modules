$(document).ready(start) ;

function start(){
	var frontpage = Drupal.settings.url ; 
	$("input#operation").click(function(){
		if($("#current-content").length){
				$("#current-content").remove() ; 
		}	
		if($("#current-row").length){
				$("#current-row").removeAttr("id") ;  
		}	
		$(this).closest("tr").attr("id" , "current-row") ; 
		var orderid = $("#current-row td:first").text() ; 
		$("#current-row").after("<tr class='message ok' ><td colspan='9' id='current-content'></td></tr>") ; 
		$("#current-content").load( frontpage + "/ajax/joury/suppliers-requests" , {"orderid" : orderid} , function(){

				
				
				// if any input text changed then change the another input text automatically
				$("#item-price-ad").keyup(function(){
					var  priceAd = $(this).val() ; 
					var  priceBd = $("#item-price-bd").val() ; 	
					var disAmount = priceBd - priceAd ; 
					$("#discount").val("") ; 
					$("#discount").val(disAmount) ; 
				});

				$("#item-price-bd").keyup(function(){
					var  priceBd = $(this).val() ; 
					var  priceAd = $("#item-price-ad").val() ; 	
					var disAmount = priceBd - priceAd ; 
					$("#discount").val("") ; 
					$("#discount").val(disAmount) ; 
				});
				
				$("#item-price-ad").keydown(function(){
					var  priceAd = $(this).val() ; 
					var  priceBd = $("#item-price-bd").val() ; 	
					var disAmount = priceBd - priceAd ; 
					$("#discount").val("") ; 
					$("#discount").val(disAmount) ; 
				});

				$("#item-price-bd").keydown(function(){
					var  priceBd = $(this).val() ; 
					var  priceAd = $("#item-price-ad").val() ; 	
					var disAmount = priceBd - priceAd ; 
					$("#discount").val("") ; 
					$("#discount").val(disAmount) ; 
				});			
				
				$("#item-price-ad").change(function(){
					var  priceAd = $(this).val() ; 
					var  priceBd = $("#item-price-bd").val() ; 	
					var disAmount = priceBd - priceAd ; 
					$("#discount").val("") ; 
					$("#discount").val(disAmount) ; 
				});

				$("#item-price-bd").change(function(){
					var  priceBd = $(this).val() ; 
					var  priceAd = $("#item-price-ad").val() ; 	
					var disAmount = priceBd - priceAd ; 
					$("#discount").val("") ; 
					$("#discount").val(disAmount) ; 
				});		
				
				
				// end of  input text changed
				
				
				$("input[name=update-quantity-submit]").mousedown(function(){
					
					var discountA = $("#discount").val() ; 
					var itemPriceAd = $("#item-price-ad").val() ; 
					var itemPriceBd = $("#item-price-bd").val() ; 
					if((itemPriceBd - itemPriceAd) != discountA ){
						alert("Please make sure that \n (Price Before Discount)  - \n (Price After Discount)  = \n (Discount Amount)") ; 
						return false ; 	
					}						
				});
				
				$("input[name=update-quantity-submit]").mouseup(function(){
					 $(this).hide() ; 
				});
			
				$("input#row-operation").mousedown(function(){ // true or false link clicked
				   $(this).hide() ;  
					var choice = $(this).attr("href") ; // 1 or 0 ... true of false
					var note = $("textarea[name=note]").val() ; 
					var discountA = $("#discount").val() ; 
					var itemPriceAd = $("#item-price-ad").val() ; 
					var itemPriceBd = $("#item-price-bd").val() ; 
					if((itemPriceBd - itemPriceAd) != discountA ){
                  alert("Please make sure that \n (Price Before Discount)  - \n (Price After Discount)  = \n (Discount Amount)") ; 
						return false ; 	
					}						
					
					$("#current-content").load(frontpage + "/ajax/joury/suppliers-requests/operation" ,{"discounta" : discountA , "item-price-bd" : itemPriceBd  , "item-price-ad" : itemPriceAd ,"orderid" : orderid , "choice" : choice , "note":note} , function (){
							$("#current-row").remove() ;
						}) ; // user hav answered and the request of answer have been send 
					return false;  
				});
			}) ;
		//$("#current-row").removeAttr("id") ; 
		return false ; 	
	});	
}	 