$(document).ready(start);

function start(){
	var frontpage = Drupal.settings.frontpage ; 
	var maincontentwidth = $("#ja-contentwrap").width() ;  // get width of main content

	$("select#edit-session").change(function(){ // session number has changed
			var session_num = $(this).val() ; 
			if(session_num == 0){
				$("div#hidden-div").html('') ; 
				return ;
			}	
			var register_id = $("#edit-register-id").val() ; 
			$("#hidden-div").load(frontpage + "clients/attendance/session/fields/generator" , {"registerid" :register_id,"session":session_num },function (){
					$("input#by").autocomplete({source: frontpage + "joury/register/service/autocomplete/staffname"});					
				
					$("#hidden-div").width(maincontentwidth-30)	 ; 			
				
					// ajax row has loaded
					$("#date").datetimepicker({ampm:true,stepMinute: 15}); 
					if(!$("input#select").attr("checked")){ // if not enabled row then disable all input
							$("#session-table input[type=text],#attend").attr("disabled" , " ") ; 
					}	 // end of : if not enabled row then disable all input
					
					$("input#select").change(function() { // checkbox have beed changed
							if($(this).attr("checked")){ // checkbox enabled
								$("#session-table input[type=text],#attend").removeAttr("disabled") ;
								return ; 
							} // end of : this checkbox enabled
							// start of : this checkbox disabled
							

							
							var validate = confirm("Are you sure you want to delete this session data?") ; 
							if(validate == 0){
								$("input#select").attr("checked","checked") ;					
								return false ; 	
							}	
							$("#session-table input[type=text],#attend").attr("disabled" , " ") ; 
							
							
													
							// end of : this checkbox disabled
					}); // end of : checkbox is changed
					
					$("#edit-submit").click(function(){ // when form is submited
						if($("input#select").attr("checked")){ // if checkbox enabled 
							if($("#date").val() == ''){
								alert("Please insert the date first") ; 
								$("#date").attr("style","border:1px solid red;") ; 
								return false ; 	
							}	
						}// end of : if checkbox enabled
					}) ;// end of when form is submitted
					
			}) ; // end of ajax row 
		
			
			
	}); // end of session number has changed
}	