$("document").ready(form) ; 

function form(){
	$("#edit-title, #edit-field-staffemployeeid-0-value, #edit-field-staffsalary-0-value").attr("size" , "30") ;
	$( "#edit-field-staffbirthdate-0-value" ).datepicker({ changeYear: true , yearRange: '1930:2011'}); 	
	$( "#edit-field-staffjoiningdate-0-value" ).datepicker({ changeYear: true , yearRange: '2000:2018'}); 
	$("#edit-field-staffattendtime-0-value").timepicker({}) ; 
	$("#edit-field-staffleavetime-0-value").timepicker({}) ; 
	}