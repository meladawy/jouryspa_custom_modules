$("document").ready(start) ; 


function start(){
	var tableOriginalContent = $("table#joury-admin-changable-table").html()	;
	var frontpage = Drupal.settings.url ; 


	$("#send").click(function(){
		$(this).hide() ; 
	});
	$("select#storeid").change(function (){
		if($(this).val() == ''){ // ma5tarsh esm store
				$("input#send").attr("disabled" , " ") ; 
				return ; 
		}
		// now he selected the store correctly ...then do the following
		if($("#dynamic-table-content tr").length > 1){
			$("input#send").removeAttr("disabled") ; 

		}
	}); // store select has changed 
	$("input#select").change(function(){ // checkbox changed
			if($(this).attr("checked")){ // this checkbox enabled
				$(this).closest("tr").attr("id" , "current-raw") ; // give unice id for this raw
				$("#current-raw").addClass("message ok") ; 
				$("#current-raw #quantity").removeAttr("disabled") ; 
				$("#current-raw").appendTo("table#dynamic-table-content") ;
				$("#dynamic-table-content").removeAttr("style") ; 
				if($("select#storeid").val() != ''){
						$("input#send").removeAttr("disabled") ; 
				}	
				$("#current-raw").removeAttr("id") ;  // remove the unice id from the parent raw
				return ;
			}	//  end of this checkbox enabled
			
				$(this).closest("tr").attr("id" , "current-raw") ; // give unice id for this raw
				$("#current-raw").removeClass("message ok") ; 
				$("#current-raw #quantity").attr("disabled"," ") ; 
				$("#current-raw").appendTo("#joury-admin-changable-table") ; 
				var dynamicTableRaws = $("#dynamic-table-content tr").length ;
				if(dynamicTableRaws == 1){
					$("#dynamic-table-content").css("display" , "none") ; 
					$("input#send").attr("disabled" , " ") ;
				}	
				$("#current-raw").removeAttr("id") ;  // remove the unice id from the parent raw			
			
			// this checkbox disabled		
	}) ; 	 // end of checkbox changed
	
	$("input#search").keyup(function() { // el search hayitkatap feeh 7aga
		var searchContent = $(this).val() ; 
		if(searchContent == ''){ // restore the original content if no search keyword
			$("table#joury-admin-changable-table").html(tableOriginalContent)	;
			return ; 
		}	
		$("table#joury-admin-changable-table").html('')	; 
		
		$("table#joury-admin-changable-table").load( frontpage + "/joury/store/admin/current/products/keyword" , {"keyword":searchContent},function (){
					$("input#select").change(function(){ // checkbox changed
							if($(this).attr("checked")){ // this checkbox enabled
								$(this).closest("tr").attr("id" , "current-raw") ; // give unice id for this raw
								$("#current-raw").addClass("message ok") ; 
								$("#current-raw #quantity").removeAttr("disabled") ; 
								$("#current-raw").appendTo("table#dynamic-table-content") ;
								$("#dynamic-table-content").removeAttr("style") ; 
								if($("select#storeid").val() != ''){
										$("input#send").removeAttr("disabled") ; 
								}	
								$("#current-raw").removeAttr("id") ;  // remove the unice id from the parent raw
								return ;
							}	//  end of this checkbox enabled
			
								$(this).closest("tr").attr("id" , "current-raw") ; // give unice id for this raw
								$("#current-raw").removeClass("message ok") ; 
								$("#current-raw #quantity").attr("disabled"," ") ; 
								$("#current-raw").appendTo("#joury-admin-changable-table") ; 
								var dynamicTableRaws = $("#dynamic-table-content tr").length ;
								if(dynamicTableRaws == 1){
									$("#dynamic-table-content").css("display" , "none") ; 
									$("input#send").attr("disabled" , " ") ;
								}	
								$("#current-raw").removeAttr("id") ;  // remove the unice id from the parent raw			
			
							// this checkbox disabled		
					}) ; 	 // end of checkbox changed
		}) ;
			
	}); // end of search changed
}	