$('document').ready(suppliers) ; 

function suppliers(){
	var frontpage = Drupal.settings.frontpage ; 
	$("input[id=joury-suppliers-button-export]").click(clickexport);
	
	function clickexport(){		
		  if($("#suppliers-export-content").length){ // check if export pressed before to remove the green content
			 	 $("#supplier-export-row").remove(); 	
			}
			$(this).parents('tr').attr('id','current-export-row') ;  // mark the parent tr
			var primarykey = $("#current-export-row td:first").text() ;  // supplier id 
			$("#current-export-row").removeAttr('id') ; 
			$(this).parents('tr').after("<tr id='supplier-export-row' ><td colspan='4'><div class='loading-d' id='suppliers-export-content' >  </div></td></tr>");
			
		   $("div[id=suppliers-export-content]").load(frontpage + '/suppliers/export/table' ,{"supplierid" : primarykey}, function(){
					$("div[id=suppliers-export-content]").removeClass('loading-d') ; 		   
		   		$("input#productkeywordsubmit").click(function(){
		   				  var searchkeyword = $("#productkeyword").val() ; 
		   					if(searchkeyword == ''){
		   						alert("please insert search word..");
		   						return false ;	
		   					}	
		   					$("div[id=suppliers-export-content]").load(frontpage + '/suppliers/export/table' ,{"supplierid" : primarykey , "productkeyword" : searchkeyword}, function(){
									$("div#suppliers-export-content a").click(function(){
											if($(this).text() == 'DETAILS'){
												var productid = $(this).attr("value") ;
													$("div#divdetails-" + productid ).css("text-align","center") ; 
													$("a#details-" + productid).fancybox({ // ll details bta3it kol order
														'titlePosition'		: 'inside',
														'transitionIn'		: 'none',
														'transitionOut'		: 'none'
													});
											}	 
											return false;  
										});
		   						$("div[id=suppliers-export-content]").removeClass('loading-d') ; 
						   	//	$("div[id=suppliers-export-content]").addClass('message ok') ; 
						   		$("input#suppliers-submit").click(function(){
						   				var storeid = $("#storeid").val() ; 
						   				var unit =  $("#unit").val() ; 
						   				/*if(storeid == ''){
						   					alert("please insert the store name") ; 
						   					$("select#storeid").css("border","2px solid red") ; 
						   					return false ; 
						   				}	*/
						   				
						   				if(unit == '' || unit < 1){
						   					alert("please change this unit..") ; 
						   					$("select#unit").css("border","2px solid red") ; 
						   					return false ; 
						   				}	
						   				if(!$("#requested-product-content").length){
						   					alert("you must select elements before send") ;
						   					return false ; 	
						   				}
						   				$("#supplier-dynamic-content").html('') ; 
						   				$("#requested-product-content tr").appendTo("#supplier-dynamic-content") ; 
						   			}); // request the table
						   			$("input#select").change(function(){
						   					 if($("#requested-product-content").length){ // exist...now i have to append 
						   					 	 
						   					 }else{ // not exist i have to create this element before suppliers-export-content
						   					 	 var newTableContent = "<table id='requested-product-content'> <tr><td  id='supplier-table-head' >PRODUCT NAME</td><td  id='supplier-table-head' >DETAILS</td><td  id='supplier-table-head' >SELECT</td></tr><table>" ; 
						   					 	 $("#jouryspa-page-table").before(newTableContent) ; 
						   					 }		
						   					 if ($(this).attr("checked")) {  //checkbox is enabled
										       $(this).closest('tr').attr('id','current-export-row') ; 
										       $("#current-export-row").addClass("message ok") ; 
										       $("#current-export-row #quantity").removeAttr("disabled") ; 
										       $("#current-export-row #price").removeAttr("disabled") ; 
										       $("#current-export-row").hide(500);
												$("#current-export-row").appendTo("#requested-product-content") ; 
				 								 $("#current-export-row").show(500) ; 
												 $("#current-export-row").removeAttr('id') ; 
											return;
										    }
										    // checkbox is disabled
										    
										    	 $(this).closest('tr').attr('id','current-export-row') ; 
										    	 $("#current-export-row").removeClass("message ok") ; 
										       $("#current-export-row #quantity").attr("disabled","23") ; 
										       $("#current-export-row #price").attr("disabled","23") ;
										       $("#current-export-row").hide(500);
										       $("#current-export-row").insertAfter("#suppliers-table-head-row") ; 
										       $("#current-export-row").show(500) ; 
												 $("#current-export-row").removeAttr('id') ; 
										});//checkbox is changed		 
		   					}); // saarch bottom clicked
		   			}) ; // click on search form
		   		
		   	}) ;  // table is loaded
			
				//	echo "<table id='requested-product-content'  style='width:100%;'>" ; 
				//echo "</table>" ;  
			
			
	}
	
	

		
}	/*.parent().after("<tr><td colspan='4'><div class='message ok'> hellllllllllllooooooooooooo </div></td></tr>") */