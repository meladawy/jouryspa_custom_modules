$(document).ready(start) ; 

function start(){
	$("a#printer-link").click(function(){
		$("td#print-row").hide() ; 
		$(this).parents("table#joury-contract-table").jqprint({ printContainer : true , importCSS : true , debug : true});
		$("td#print-row").show() ; 
	}); 
}	