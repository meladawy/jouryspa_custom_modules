jQuery("document").ready(start) ; 

function start() {
	var modulePath = Drupal.settings.modulePath ; 
	var imagePath = modulePath + "/loading.gif" ; 
	jQuery("#edit-submit").click(function(){
	//	jQuery(this).attr("disabled", " ") ;
		jQuery("#space-wrapper").append("<center><img src='" + imagePath + "'></center>") ; 	
	});	
}	