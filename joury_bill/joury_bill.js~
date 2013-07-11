$(document).ready(startthis);


function startthis(){
$("a[id=bill]").fancybox({
	onComplete  :   billprocess,
}) ; 
$("div[id=bill-container]").click(function(){
index  = $("div").index(this);	
});
$("#joury-bill-bills td:even").css("background","#131313") ;
$("td[id=joury-bill-bills-row]").mouseenter(function () {
	$(this).css("background","#ADADAD") ;
}); 
$("td[id=joury-bill-bills-row]:even").mouseleave(function () {
	$(this).css("background","#131313") ;
});
$("td[id=joury-bill-bills-row]:odd").mouseleave(function () {
	$(this).css("background","#343434") ;
});  
if(Drupal.settings.clientid){
var viewclientid  = Drupal.settings.clientid ;
//alert(viewclientid) ;
$("a[href=bill/client/"+ viewclientid +"]").click()	;
}
 
function billprocess(){
var frontpage = Drupal.settings.url ; 
	/*$("input[id=next]").click(function() {
		var discount = parseInt($("#discount").val()) ; 
 		var staffid =  parseInt($("#follower").val()) ; 
  		var cashier =  $("#cashier").val() ; 	
  		var clientid =  parseInt($("#clientid").val()) ; 	
		$("#ajax-bill-client").html('');
		$("#ajax-bill-client").addClass('loading-d') ; 
		$("#ajax-bill-client").load( frontpage + "ajax/bill/next/process" , {"discount" : discount ,
		 "clientid" : clientid ,"staffid":staffid }, function (BillData){
				 $("#ajax-bill-client").removeClass('loading-d') ; 
				 $("#ajax-bill-client").html(BillData) ; 
					$("#ajax-bill-client").printArea({mode: "iframe", popClose: true});
				
		 } );

	});*/

}	 

}