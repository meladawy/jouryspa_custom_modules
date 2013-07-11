$(document).ready(start) ;

function start(){
	$("#printer-link").click(function(){
			$("#report-table").jqprint({ printContainer : true , importCSS : true , debug : true});
			return false ; 
	});
}	