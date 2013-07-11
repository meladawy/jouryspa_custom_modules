$(document).ready(startthis);


function startthis(){
$("a[id=store]").fancybox({
	onComplete  :   selectchanged,
}) ;
$("div[id=store-container]").click(function(){
index  = $("div").index(this);	
});
$("#joury-store-stores td:even").css("background","#131313") ;
$("td[id=joury-store-stores-row]").mouseenter(function () {
	$(this).css("background","#ADADAD") ;
}); 
$("td[id=joury-store-stores-row]:even").mouseleave(function () {
	$(this).css("background","#131313") ;
});
$("td[id=joury-store-stores-row]:odd").mouseleave(function () {
	$(this).css("background","#343434") ;
}); 
function selectchanged(){
	var frontpage = Drupal.settings.url ; 
$("select[id=joury-store-menu]").change(function(){
		if($(this).val() != 0 ){
			 var selectedOption = $(this).val() ;
			 var sitepath = Drupal.settings.url ; 
			  if($("#joury-store-green-row").length){ // remove green content if exist
			 	 	$("#joury-store-green-row").remove(); 	
				}
				$(this).parents('tr').attr('id','current-export-row') ;  // mark the parent tr
				var productid = $("tr[id=current-export-row] td:first").text() ;  // supplier id 
				var storeid = $(this).parents('tr').attr('value') ; 
				$("#current-export-row").removeAttr('id') ; 
				$(this).parents('tr').after("<tr id='joury-store-green-row' ><td colspan='5'><div class='loading-d' id='joury-store-option-content' >  </div></td></tr>");	
				$("#joury-store-option-content").load( sitepath + "/joury/store-products/table" , {"selected-option" : selectedOption , "product-id":productid , "store-id":storeid } ,function (Data){
						$(this).removeClass("loading-d") ; 
						$(this).addClass("ok") ;
						$(this).html(Data) ;  
						$("#date").datepicker({ changeYear: true , yearRange: '2000:2018'});
						$("input[id=staff-submit-product]").click(function (){	
		
									var indexdiv = index ; 			 
									var staffid = $("#staff").val() ; 
									var price = $("#price").val() ; 
									var productid = $("#productid").val() ;
									var storeid = $("#storeid").val() ;  
									var quantity = parseInt($("#quantity").val()) ; 
									var date = $("#staffdate").val() ;
									var productQuantity = $("#productquantity").val() ; 
									var staffQuantity = parseInt(productQuantity) ; 
									if(staffid == '' || price == '' || productid == '' || storeid == '' || quantity == '' || date == ''){
										alert("please complete the fields..!!") ;	
										return ;
									}
									
									if(quantity > staffQuantity){
										alert("Too much Quantity !!!") ;		
										return ; 
									}
									
										
								//ajax/staff/from-store/process
									$("#joury-store-option-content").html('') ; 	
									$("#joury-store-option-content").removeClass("ok") ; 
									$("#joury-store-option-content").addClass("loading-d") ;
									$("#joury-store-option-content").load(sitepath + "ajax/staff/from-store/process" , {"staffid":staffid,
									"productid" : productid,"price":price,"storeid":storeid,"quantity":quantity,"date":date }, function (staffData){
										$("div").eq(index).find("a").click() ;	
										}); 
											 						
							});
						$("input[id=showroom-submit-product]").click(function (){							
									var showroomid = $("#showroom").val() ; 
									var price = $("#price").val() ; 
									var productid = $("#productid").val() ;		
									var storeid = $("#storeid").val() ;  
									var quantity = parseInt($("#quantity").val()) ; 
									var date = $("#showroomdate").val() ;
									var productQuantity = $("#productquantity").val() ; 
									var showroomQuantity = parseInt(productQuantity) ; 
									if(showroomid == '' || price == '' || productid == '' || storeid == '' || quantity == '' || date == ''){
										alert("please complete the fields..!!") ;	
										return ;
									}
									
									if(quantity > productQuantity){
										alert("Too much Quantity !!!") ;		
										return ; 
									}
										
									//ajax/showrooms/from-store/process
									$("#joury-store-option-content").html('') ; 	
									$("#joury-store-option-content").removeClass("ok") ; 
									$("#joury-store-option-content").addClass("loading-d") ;
								$("#joury-store-option-content").load(sitepath + "ajax/showrooms/from-store/process" , {"showroomid":showroomid,
									"productid" : productid,"price":price ,"storeid":storeid,"quantity":quantity,"date":date }, function (showroomData){
										$("div").eq(index).find("a").click() ;											
										
										}); 
									 		
											 						
							});
						
					}) ;	
		}	 
	});	
	
	$("input#productname").keyup(function(){ // someone search for product to request		
		if($(this).val() == ''){ // if the search form is empty
			$("table#joury-store-requests-search-result-table").html('') ;
			return  ; 
		} // end of: if the search form is empty	
		
		var searchkeyword = $(this).val() ; 
		$("table#joury-store-requests-search-result-table").load( frontpage + "joury/store-products/requests/table-content/generator"
		,{"keyword":searchkeyword},function(){
			$("input#select").change(function(){ // checkbox hav changed
					if($(this).attr("checked")){ // we are now enabling the checkbox
							$(this).closest("tr").attr("id","current-raw-selected") ; 
							$("#current-raw-selected").addClass("message ok") ; 
							$("#current-raw-selected").appendTo("#joury-store-requests-selected-result-table") ; 
							$("#make-request").removeAttr("disabled") ;
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
					if($("#joury-store-requests-selected-result-table tr").length == 0){
						$("#make-request").attr("disabled"," ") ;	
					}		
					
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
	
	
}	

}	 