$(document).ready(start) ;

function start(){
	$("#edit-datefrom").datepicker();	
	$("#edit-dateto").datepicker();	
	$("#printer-link").click(function(){
			$("#staff-report-table").jqprint({ printContainer : true , importCSS : true , debug : true});
			return false ; 
	});
}	
