$(document).ready(start) ; 

function start(){
		var frontpage = Drupal.settings.frontpage ; 
		
	// make clientname select box a combo box	
	window.dhx_globalImgPath = frontpage + "sites/all/modules/joury_register_service/codebase/imgs/";
	var z=dhtmlXComboFromSelect("edit-client-name");
	z.enableFilteringMode(true);	
	
	// make clientphone select box a combo box	
	window.dhx_globalImgPath = frontpage + "sites/all/modules/joury_register_service/codebase/imgs/";
	var p=dhtmlXComboFromSelect("edit-client-phone");
	p.enableFilteringMode(true);	
	
		// empty input when - pressed
	z.attachEvent("onKeyPressed", function(keyCode){
		if(keyCode == 189){
			z.DOMelem_input.value = "" ; 
		}	
	});  
	
			// empty input when - pressed
	p.attachEvent("onKeyPressed", function(keyCode){
		if(keyCode == 189){
			p.DOMelem_input.value = "" ; 
		}	
	});  
	

	z.attachEvent("onChange",function(id,index,value){  // form client name is changed	
		var clientname = $("input[name=client-name]").val() ;  // current client name
		$("div#hidden-div").load( frontpage + "clients/attendance/clientdata/result" ,{"clientname":clientname} , function(){
			
		});
	}) ;
	
	p.attachEvent("onChange",function(id,index,value){  // form client name is changed
		var clientdata = $("input[name=client-phone]").val() ;  // current client name
		$("div#hidden-div").load( frontpage + "clients/attendance/clientdataphone/result" ,{"clientdata":clientdata} , function(){
			
		});
	}) ;
}	