$(document).ready(start) ;

function start(){
	$("#edit-date-from").datepicker();	
	$("#edit-date-to").datepicker();	
	$("#printer-link").click(function(){
			$("#service-report-table").jqprint({ printContainer : true , importCSS : true , debug : true});
			return false ; 
	});
}	