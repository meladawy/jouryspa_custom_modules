$(document).ready(start);

function start(){
	var frontpage = Drupal.settings.url ; 
	
	// make service select box a combo box	
	window.dhx_globalImgPath = frontpage + "sites/all/modules/joury_register_service/codebase/imgs/";
	var supplierfield=dhtmlXComboFromSelect("edit-supplier");
	supplierfield.enableFilteringMode(true);	
	
		
	// empty input when - pressed
	supplierfield.attachEvent("onKeyPressed", function(keyCode){
		if(keyCode == 189){
			supplierfield.DOMelem_input.value = "" ; 
		}	
	});  
	

	$("#edit-make-request").click(function(){
		var confirmRequest = confirm("Are you sure you want to send the Request ?") ;
		if(!confirmRequest){
			return false ; 
		} 
	});
	
	
	$("#edit-make-request").attr("disabled"," ") ; // disable make request by default
	$("input#edit-product").keyup(function(){ // product field is edited
			var productKeyword = $(this).val() ; 
			var suppliername = $("input[name=supplier]").val() ; 
			$("#result-fieldset").load(frontpage + '/suppliers/export/table'  , {"suppliername" : suppliername , "productkeyword" : productKeyword} ,function(){ // load the ajax content to result field set
				$("#suppliers-export-table tr:not(:first)").each(function(){ // action on each raw in the result
						$(this).attr("id","current-result-raw") ; 
						 var keynum = $("#current-result-raw #keynumber").val() ; 
						 
						 // disable text field when found product
						 $("#result-fieldset input[type='text']").attr("disabled" , " ") ;
						 // if someone clicked on details bottom do no thing
						 $("a#details-" + keynum).click(function(){ // when click on DETAILS BOTTOM	 		
						 		return false ; 
						 }	);
						 
						 //fancy box on details bottom
						 $("a#details-" + keynum).fancybox({ // ll details bta3it kol order
														'titlePosition'		: 'inside',
														'transitionIn'		: 'none',
														'transitionOut'		: 'none'
						 });
						 
						$("div#divdetails-" + keynum ).css("text-align","center") ;	 // align center for divs					 
						 
						$("#current-result-raw").removeAttr("id") ; 
					}) ; // loop is ended
					
				$("input#select").change(function(){ // checkbox is selected
						if($(this).attr("checked")){ // this checkbox enabled
								$(this).closest('tr').attr('id','current-export-row') ; 
								var thisrowexist = 0 ; 
								var currentService = $("#current-export-row td:first").text();
								// disable all select field
								
								$("#current-export-row input[type=text]").removeAttr("disabled") ;								
								
								// check if this product exist before
								$("#selected-fieldset tr").each(function(){
									$(this).attr("id" , "counted-row") ; 
									var rowService = $("#counted-row td:first").html() ; 
									if(currentService == rowService){
										alert("Sorry this product selected before") ; 	
										thisrowexist = 1 ; 								
										
									}	 
									$("#counted-row").removeAttr("id") ; 
								});	
								if(thisrowexist == 1){
									$("#current-export-row").remove() ;
									if($("#result-fieldset tr").length == 1){
									$("#result-fieldset #suppliers-export-table").remove(); 
									}
									return ; 	
								}							
								
								$("#current-export-row").addClass("message ok") ; 
				     	      $("#current-export-row").hide(100);
				     	      if($("#selected-fieldset tr").length == 0){
				     	      	$("#selected-fieldset").append("<table id='suppliers-export-table' > <tr id='suppliers-table-head-row' ><td id='supplier-table-head'><strong>PRODUCT NAME</strong></td> <td id='supplier-table-head'><strong>QUANTITY</strong></td> <td id='supplier-table-head'><strong>ITEM PRICE BEFORE DISCOUNT</strong></td> <td id='supplier-table-head'><strong>DISCOUNT</strong></td> <td id='supplier-table-head'><strong>UNSELECT</strong></td></tr> </table>") ; 
				     	      }	 
								$("#current-export-row").appendTo("#selected-fieldset #suppliers-export-table") ; 
								if($("#result-fieldset tr").length == 1){
									$("#result-fieldset #suppliers-export-table").remove(); 
								}	
				 				$("#current-export-row").show(100) ; 
				 				$("#edit-make-request").removeAttr("disabled") ; 
								$("#current-export-row").removeAttr('id') ; 
							return ; 
						} // end of this checkbox enabled	
						// this checkbox disabled
						
								$(this).closest('tr').attr('id','current-export-row') ; 
								$("#current-export-row").removeClass("message ok") ; 
								$("#current-export-row").remove();
								if($("#selected-fieldset tr").length == 1){
									$("#selected-fieldset #suppliers-export-table").remove() ; 
								}	

								if($("#selected-fieldset tr").length == 0){
									$("#edit-make-request").attr("disabled"," ") ; // disable make request by default
								}	
								$("#current-export-row").removeAttr('id') ; 
						
						
						// end of this checkbox disabled
				});	// checkbox is selected
			}) ; // ajax load is ended
	}) ; // product field is edited
}	 