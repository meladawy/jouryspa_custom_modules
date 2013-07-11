$("document").ready(form) ; 

function form(){
	$("#edit-title").attr("size" , "30") ;
	$( "#edit-field-clientbirthdate-0-value" ).datepicker({ changeYear: true , yearRange: '1930:2011'}); 	
	$( "#edit-field-clientjoiningdate-0-value" ).datepicker({ changeYear: true , yearRange: '2000:2018'}); 
	}