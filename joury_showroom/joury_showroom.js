$(document).ready(startthis);


function startthis(){
$("a[id=showroom]").fancybox({
	onComplete  :   selectchanged,
}) ; 
$("div[id=showroom-container]").click(function(){
index  = $("div").index(this);	
});
$("#joury-showroom-showrooms td:even").css("background","#131313") ;
$("td[id=joury-showroom-showrooms-row]").mouseenter(function () {
	$(this).css("background","#ADADAD") ;
}); 
$("td[id=joury-showroom-showrooms-row]:even").mouseleave(function () {
	$(this).css("background","#131313") ;
});
$("td[id=joury-showroom-showrooms-row]:odd").mouseleave(function () {
	$(this).css("background","#343434") ;
});  

function selectchanged(){
var frontpage = 	Drupal.settings.url ;
$("select[id=joury-showroom-menu]").change(function(){
		if($(this).val() != 0 ){
			 var selectedOption = $(this).val() ;
			 var sitepath = Drupal.settings.url ; 
			  if($("#joury-showroom-green-row").length){ // remove green content if exist
			 	 	$("#joury-showroom-green-row").remove(); 	
				}
				$(this).parents('tr').attr('id','current-export-row') ;  // mark the parent tr
				var productid = $("#current-export-row td:first").text() ;  // supplier id 
				var showroomid = $(this).parents('tr').attr('value') ; 
				$("#current-export-row").removeAttr('id') ; 
				$(this).parents('tr').after("<tr id='joury-showroom-green-row' ><td colspan='6'><div class='loading-d' id='joury-showroom-option-content' >  </div></td></tr>");	
				$("#joury-showroom-option-content").load( sitepath + "/joury/showroom-products/table" , {"selected-option" : selectedOption , "productid":productid , "showroomid":showroomid } ,function (Data){
						$("#joury-showroom-option-content").removeClass("loading-d") ; 
						$("#joury-showroom-option-content").addClass("ok") ;
						$("#joury-showroom-option-content").html(Data) ;
						$("#date").datepicker({ changeYear: true , yearRange: '2000:2018'});
						$("select[id=client]").change(function (){
							var clientid = $("#client").val() ; 
									if($("#joury-showroom-client-green-row").length){ // remove green content if exist
			 	 							$("#joury-showroom-client-green-row").remove(); 	
									}				
									if(clientid != '0' ){				
											$(this).parents('#joury-showroom-products-option-head-row').after("<tr id='joury-showroom-client-green-row' ><td colspan='4'><div class='ok' id='joury-showroom-option-client-content' ></div></td></tr>");	
											$("#joury-showroom-option-client-content").load( sitepath + "ajax/clients/from-showroom/info" , {"clientid" : clientid } ,function (clientData){
													$(this).html('') ;  
													$(this).html(clientData) ; 
												});						
									}	
							});
						$("input[id=client-sell-product]").click(function (){
									var clientid = $("#client").val() ; 
									var sellPrice = $("#sellprice").val() ; 
									var price = $("#price").val() ; 
									var productid = $("#productid").val() ;
									var showroomid = $("#showroomid").val() ;  
									var quantity = parseInt($("#quantity").val()) ; 
									var date = $("#date").val() ;
									var productquantity = parseInt($("#productquantity").val()) ; 
									if(clientid == '0'|| sellPrice == '' || price == '' || productid == '' || showroomid == '' || quantity == '' || date == ''){ 
										alert("please complete the fields..!!") ;	
										return ;
									}
									
									if(quantity > productquantity){
										alert("Too much Quantity !!!") ;
										return ; 
									}
										
										//ajax/staff/from-showroom/process
									$("#joury-showroom-option-content").html('') ; 	
									$("#joury-showroom-option-content").removeClass("ok") ; 
									$("#joury-showroom-option-content").addClass("loading-d") ;
									$("#joury-showroom-option-content").load(sitepath + "ajax/clients/from-showroom/process" , {"clientid":clientid,
									"productid" : productid,"price":price,"sellPrice":sellPrice,"showroomid":showroomid,"quantity":quantity,"date":date }, function (clientData){
										$("div").eq(index).find("a").click() ;									 
										}); 
											 						
							});
						$("input[id=store-back-product]").click(function (){

									var storeid = $("#storeid").val() ; 
									var sellPrice = $("#sellprice").val() ; 
									var price = $("#price").val() ; 
									var productid = $("#productid").val() ;
									var showroomid = $("#showroomid").val() ;  
									var quantity = parseInt($("#quantity").val()) ; 
									var date = $("#date").val() ;
									var productquantity = parseInt($("#productquantity").val()) ; 
									

									if(storeid == ''|| sellPrice == '' || price == '' || productid == '' || showroomid == '' || quantity == '' || isNaN(quantity)|| date == ''){ 
										alert("please complete the fields..!!") ;	
										return ;
									}

									
									if(quantity > productquantity){
										alert("Too much Quantity !!!") ;		
										return ; 
									}

										
									//ajax/showrooms/from-showroom/process
									$("#joury-showroom-option-content").html('') ; 	
									$("#joury-showroom-option-content").removeClass("ok") ; 
									$("#joury-showroom-option-content").addClass("loading-d") ;
									$("#joury-showroom-option-content").load(sitepath + "ajax/showrooms/from-showroom/process" , {"showroomid":showroomid,
									"productid" : productid,"price":price,"quantity":quantity,"date":date,"storeid" : storeid }, function (showroomData){
										$("div").eq(index).find("a").click() ;	
										}); 
									 		
											 						
							});
						
					}) ;	
		}	 
	});	
	$("input#productname").keyup(function(){ // someone search for product to request		
		if($(this).val() == ''){ // if the search form is empty
			$("table#joury-showroom-requests-search-result-table").html('') ;
			return  ; 
		} // end of: if the search form is empty	
		
		var searchkeyword = $(this).val() ; 
		var productsupplier = $("#request-supplierid").val() ;
		$("table#joury-showroom-requests-search-result-table").load( frontpage + "joury/showroom-products/requests/table-content/generator"
		,{"keyword":searchkeyword ,"productsupplier":productsupplier},function(){
			$("input#select").change(function(){ // checkbox hav changed
					if($(this).attr("checked")){ // we are now enabling the checkbox
							$(this).closest("tr").attr("id","current-raw-selected") ; 
							$("#current-raw-selected").addClass("message ok") ; 
							$("#current-raw-selected").appendTo("#joury-showroom-requests-selected-result-table") ; 
							$("#current-raw-selected #quantity").removeAttr("disabled") ; 
							$("#current-raw-selected").removeAttr("id") ; 
							return ; 
					} // end of enabling the checkbox
					
					// disabling the checkbox
					$(this).closest("tr").attr("id","current-raw-selected") ; 
					$("#current-raw-selected").removeClass("message ok") ; 
					$("#current-raw-selected").remove() ; 
					$("#current-raw-selected #quantity").attr("disabled"," ") ; 
					$("#current-raw-selected").removeAttr("id") ; 					
					
					// end of disabling the checkbox
			}); // end of change the checkbox
			
		$("input#quantity").change(function (){ // end of changing the quantity
				var changedValue = $(this).val() ; 
				var number = 1 ; 
				if(changedValue == '' || changedValue == 0) {
					alert("please insert number in quantity..") ; 
					$(this).val(number) ;
					return ;	
				}
				if(isNaN(changedValue)){
					alert("please insert number in quantity..") ; 
					$(this).val(number) ;
					return ;		
				}	// end if quantity number validating
				 	
			
		});// end of change the quantity
			
		}) ; // end of load the content of search result
		
		
	});//  end of  : someone search for product to request
	
	$("select#request-supplierid").change(function (){ //someone change the supplierid .. so i have to enable the make request submit
			if($(this).val() != ''){
				$("#make-request").removeAttr("disabled") ; 
				
			}else{
				$("#make-request").attr("disabled" , " ") ; 
			}	
		}) ; // endof: someone change the storeid .. so i have to enable the make request submit
}	

}	 
