$(document).ready(start) ; 

function start(){
	var frontpage = Drupal.settings.frontpage ; 
 	$("#edit-clientid").change(function(){ //  client name is change
	var clientid = $(this).val() ; 
	if(clientid != ''){
		$("#client-services").load(frontpage + '/generate/client/service/table' , {'clientid' : clientid} , function(){  ;
			
		}) ; 
	}else{
		$("#client-services").html('') ; 
	}	
	}) ; // end of client name is changed
}	