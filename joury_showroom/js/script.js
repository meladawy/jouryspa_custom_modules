$(document).ready(start) ; 

function start(){
	var tablecolumns = Drupal.settings.numberofcolumns ; 
	var frontpage = Drupal.settings.frontpage ; 
	$("#jouryspa-page-table td").width(100/tablecolumns) ;

	window.dhx_globalImgPath = frontpage + "sites/all/modules/joury_register_service/codebase/imgs/";
	
	$("select").each(function(){
		var selectmenuid = $(this).attr("id")  ; 
		var z=dhtmlXComboFromSelect(selectmenuid);
		z.enableFilteringMode(true);
	}) ; 
	
	$("#jouryspa-page-table td").wrapInner("<center/>") ; 


 
}	 ; 