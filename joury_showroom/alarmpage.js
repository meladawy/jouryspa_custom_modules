$(document).ready(start);

function start(){
	var frontpage = Drupal.settings.frontpage ; 	
	
	
	// make store name  select box a combo box	
	window.dhx_globalImgPath = frontpage + "sites/all/modules/joury_register_service/codebase/imgs/";
	var z=dhtmlXComboFromSelect("edit-showroom");
	z.enableFilteringMode(true);
	
}
