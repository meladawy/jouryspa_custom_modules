$(document).ready(start) ; 


function start(){
			$("#products-manager").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
			
			$("a#done").click(function(){
				var validate = confirm("Do you want confirm this request?") ;
				if(validate == 1){
					$(this).closest("tr").attr("id","current-raw") ; 
					$("#current-raw").addClass("message ok") ; 
					var requestId = $("#current-raw td:first").text() ; 
					$.post("", { "requestremoveid" : requestId } );
					$("#current-raw").remove() ; 
					$("#current-raw").removeAttr("id") ;
				}
				return false ; 
			});
}	