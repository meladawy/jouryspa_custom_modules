$(document).ready(start) ;

function start(){
	if($("input#edit-field-productrate-0-value").val() == '' && $("input#edit-field-productsellingprice-0-value").val() != ''){
			$("input#edit-field-productrate-0-value").val("") ; 
			$("input#edit-field-productrate-0-value").attr("style" , "background:#ccc;") ;	
			$("input#edit-field-productrate-0-value").click(function(){
				if($("input#edit-field-productsellingprice-0-value").val() != ''){
					$("input#edit-field-productsellingprice-0-value").focus() ; 					
				}
			});
	}		
	
	if($("input#edit-field-productsellingprice-0-value").val() == '' && $("input#edit-field-productrate-0-value").val() != ''){
			$("input#edit-field-productsellingprice-0-value").val("") ; 
			$("input#edit-field-productsellingprice-0-value").attr("style" , "background:#ccc;") ;	
			$("input#edit-field-productsellingprice-0-value").click(function(){
				if($("input#edit-field-productrate-0-value").val() != ''){
					$("input#edit-field-productrate-0-value").focus() ; 
				}
			});
	}	
	
	
	
	$("input#edit-field-productrate-0-value").keyup(function(){
		var ratevalue =  $(this).val() ;
		if(ratevalue != ''){
			$("input#edit-field-productsellingprice-0-value").val("") ; 
			$("input#edit-field-productsellingprice-0-value").attr("style" , "background:#ccc;") ;	
			$("input#edit-field-productsellingprice-0-value").click(function(){
				if($("input#edit-field-productrate-0-value").val() != ''){
					$("input#edit-field-productrate-0-value").focus() ; 
				}
			});
		}else{
			$("input#edit-field-productsellingprice-0-value").removeAttr("disabled") ; 	
			$("input#edit-field-productsellingprice-0-value").removeAttr("style") ; 
		}	
	});
	
	
	
		$("input#edit-field-productsellingprice-0-value").keyup(function(){
		var sellprice =  $(this).val() ;
		if(sellprice != ''){
			$("input#edit-field-productrate-0-value").val("") ; 
			$("input#edit-field-productrate-0-value").attr("style" , "background:#ccc;") ;	
			$("input#edit-field-productrate-0-value").click(function(){
				if($("input#edit-field-productsellingprice-0-value").val() != ''){
					$("input#edit-field-productsellingprice-0-value").focus() ; 					
				}
			});
		}else{
			$("input#edit-field-productrate-0-value").removeAttr("disabled") ; 	
			$("input#edit-field-productrate-0-value").removeAttr("style") ; 
		}	
	});
}	