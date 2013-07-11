$(document).ready(start) ; 


function start(){
			var frontpage  = Drupal.settings.url ; 
			
			$("a#p-m").click(function(){
					if($("#current-raw").length == 1){
						$("#current-raw").removeAttr("id") ; 	
					}	 					
					$("#p-m-conifguration").remove() ; 
					$("#a-s-conifguration").remove() ;
					$("#remove-conifguration").remove() ;
					$(this).closest("tr").attr("id","current-raw") ; 
					var requestId = $("#current-raw td:first").text() ; 
					var quantity = $("#current-raw td:eq(4)").text() ; 
					var productId = $("#current-raw #product-id").text() ;  
					var storeId =  $("#current-raw td:eq(5)").text() ;
					$("#current-raw").after("<tr class='message ok' ><td id='p-m-conifguration' colspan='7' > </td></tr>") ; 
					$("#p-m-conifguration").load( frontpage + "joury/store/requests/lists/p-m" ,{"request-id" : requestId,"product-id":productId,"quantity":quantity }, function(){
							$("input#send-product").mousedown(function(){
								$(this).hide(); 
								$(this).attr("disabled" , " ") ;								
								var sendQuantity = $("#move-quantity").val() ; 
								$.post(frontpage + "joury/store/requests/lists/p-m/process", {"send-quantity" : sendQuantity , "request-id":requestId ,"product-id":productId ,"store-id":storeId} , function(Date){
									var requestQuantity = $("#current-raw td:eq(4)").text() ; 
									var newQuantity = requestQuantity - sendQuantity ; 
									if(newQuantity > 0){					
										$("#current-raw td:eq(4)").text(requestQuantity - sendQuantity) ;  
										$("#requested-quantity").text(requestQuantity - sendQuantity) ;  
										$("#current-raw a#p-m").click() ; 
									}else{
										$("#p-m-conifguration").remove() ;
										$("#current-raw").remove() ; 
									}	
								});
								return false ; 
							});
							
							
					});	
				return false ; 
			});






			$("a#a-s").click(function(){
					if($("#current-raw").length == 1){
						$("#current-raw").removeAttr("id") ; 	
					}	 					
					$("#p-m-conifguration").remove() ; 
					$("#a-s-conifguration").remove() ;
					$("#remove-conifguration").remove() ;
					$(this).closest("tr").attr("id","current-raw") ; 
					var requestId = $("#current-raw td:first").text() ; 
					var quantity = $("#current-raw td:eq(4)").text() ; 
					var productId = $("#current-raw #product-id").text() ;  
					var storeId =  $("#current-raw td:eq(5)").text() ;
					$("#current-raw").after("<tr class='message ok' ><td id='a-s-conifguration' colspan='7' > </td></tr>") ; 
					$("#a-s-conifguration").load( frontpage + "joury/store/requests/lists/a-s" ,{"request-id" : requestId,"product-id":productId,"quantity":quantity }, function(){
						
							$("#from-storeid").change(function(){
								var fromstoreid =  $(this).val() ; 	
								if(fromstoreid != ''){
									$.post(frontpage + "joury/store/requests/lists/a-s/store/quantity" , {"from-store-id" : fromstoreid,"productid" : productId,"requested-quantity":quantity } , function(Date){
										$("#new-quantity-label").remove() ; 
										$("#new-quantity-value").remove() ; 										
															 				
										$("#from-store-label").after("<td id='new-quantity-label'> MOVE QUANTITY </td>") ; 
										$("#from-store-value").after(Date) ; 
									});
								}else{
										$("#new-quantity-label").remove() ; 
										$("#new-quantity-value").remove() ; 
								}		
							});
						
							$("input#send-product").mousedown(function(){
								$(this).hide() ; 
								$(this).attr("disabled" , " ") ;		
								var fromstoreid =  $("#from-storeid").val() ; 
								var sendQuantity = $("#new-quantity-value select").val() ; 
								$.post(frontpage + "joury/store/requests/lists/a-s/process", {"send-quantity" : sendQuantity , "request-id":requestId ,"product-id":productId ,"to-store-id":storeId,"from-store-id": fromstoreid} , function(Date){
									var requestQuantity = $("#current-raw td:eq(4)").text() ; 
									var newQuantity = requestQuantity - sendQuantity ; 
									if(newQuantity > 0){					
										$("#current-raw td:eq(4)").text(requestQuantity - sendQuantity) ;  
										$("#requested-quantity").text(requestQuantity - sendQuantity) ;  
										$("#current-raw a#a-s").click() ; 
									}else{
										$("#a-s-conifguration").remove() ;
										$("#current-raw").remove() ; 
									}	
								});
								return false ; 
							});
							
							
					});	
				return false ; 
			});
			
			
			
			$("a#remove").click(function(){
				   
					if($("#current-raw").length == 1){
						$("#current-raw").removeAttr("id") ; 	
					}	 					
					$("#p-m-conifguration").remove() ; 
					$("#a-s-conifguration").remove() ;
					$("#remove-conifguration").remove() ;
					$(this).closest("tr").attr("id","current-raw") ; 
					var requestId = $("#current-raw td:first").text() ; 
					var quantity = $("#current-raw td:eq(4)").text() ; 
					var productId = $("#current-raw #product-id").text() ;  
					var storeId =  $("#current-raw td:eq(5)").text() ;
					$("#current-raw").after("<tr class='message ok' ><td id='remove-conifguration' colspan='7' ><strong>NOTE:</strong><br/><textarea id='remove-note' cols='115' rows='5'> </textarea><br/><input type='submit' value='REMOVE' id='do-remove' /></td></tr>") ; 
					
							$("input#do-remove").mousedown(function(){
								$(this).hide(); 
								var removeNote = $("#remove-note").val() ; 
								$.post(frontpage + "joury/store/requests/lists/remove/process", {"request-id":requestId ,"product-id":productId ,"store-id":storeId, "note" : removeNote} , function(Date){

										$("#remove-conifguration").remove() ;
										$("#current-raw").remove() ; 

								});
								return false ; 
							});
							
							
				
				return false ; 
			});



}	