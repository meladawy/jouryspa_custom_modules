$(document).ready(mego) ; 



function mego(){
	$("a#printer-link").click(function(){
		$("td#print-row").hide() ; 
		$(this).parents("#ajax-bill-client2").jqprint({ printContainer : true , importCSS : true , debug : true});
		$("td#print-row").show() ; 
	}); 
}	