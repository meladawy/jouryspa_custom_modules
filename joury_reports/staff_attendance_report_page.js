jQuery(document).ready(start) ;

function start(){
	jQuery("#printer-link").click(function(){
			jQuery("#staff-report-table").jqprint({ printContainer : true , importCSS : true , debug : true});
			return false ; 
	});
}	
