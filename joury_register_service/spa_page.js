$(document).ready(start) ; 
function start(){
	var frontpage = Drupal.settings.frontpage ; 
	$("#edit-payment-method").change(function(){ // payment method changed generate form
			if($(this).val() == 'kenet'){
			$("#edit-payment-method-wrapper").append("<div id='kenet-receibt-div' ><strong>Receipt No </strong>:<input type='text' name='kenet-receipt' id='kenet-receipt' /> </div>") ; 	
			}else{
			$("#kenet-receibt-div").remove() ; 
			}	 
		});	 // end of payment method changed
		
		
	// make service select box a combo box	
	window.dhx_globalImgPath = frontpage + "sites/all/modules/joury_register_service/codebase/imgs/";
	var z=dhtmlXComboFromSelect("edit-service-name");
	z.enableFilteringMode(true);
	
	
	// make clients select box a combo box	
	window.dhx_globalImgPath = frontpage + "sites/all/modules/joury_register_service/codebase/imgs/";
	var t=dhtmlXComboFromSelect("edit-client-name");
	t.enableFilteringMode(true);
	
	// make clients phone select box a combo box	
	window.dhx_globalImgPath = frontpage + "sites/all/modules/joury_register_service/codebase/imgs/";
	var m=dhtmlXComboFromSelect("edit-client-phone");
	m.enableFilteringMode(true);
	
	// empty input when - pressed
	t.attachEvent("onKeyPressed", function(keyCode){
		if(keyCode == 189){
			t.DOMelem_input.value = "" ; 
		}	
	});  
	
		// empty input when - pressed
	m.attachEvent("onKeyPressed", function(keyCode){
		if(keyCode == 189){
			m.DOMelem_input.value = "" ; 
		}	
	});  
	
	// empty input when - pressed
	z.attachEvent("onKeyPressed", function(keyCode){
		if(keyCode == 189){
			z.DOMelem_input.value = "" ; 
		}	
	});  
	

	t.attachEvent("onChange",function(id,index,value){  // form client name is changed
		var inputName = $(this).attr('name')  ;
		var clientname = $("input[name="+inputName+"]").val()  ;// current client name
		$("div#hidden-div").load( frontpage + "joury/register/service/clientname/result" ,{"clientname":clientname} , function(){
			var phone = $("div#hidden-div table tr:eq(1) td:eq(1)").text() ;
			m.DOMelem_input.value = phone ; 
		});
	}) ; // end of : form client name is changed
	
	
	m.attachEvent("onChange",function(id,index,value){   // form client PHONE is changed
		var inputName = $(this).attr('name')  ;
		var clientphone = $("input[name="+inputName+"]").val()  ;// current client name
		$("div#hidden-div").load( frontpage + "joury/register/service/clientphone/result" ,{"clientphone":clientphone} , function(){
			var name = $("div#hidden-div table tr:eq(1) td:eq(0)").text() ;
			t.DOMelem_input.value = name ; 
		});
	}) ; // end of : form client name is changed	
	
	
	// add new client link
	
	$("a#add-client").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
	
	// end of new client link	
	
	z.attachEvent("onChange",function(id,index,value){ // form service name is changed
		var inputName = $(this).attr('name')  ;
		var servicename = $("input[name="+inputName+"]").val()  ;  // current client name
		$("div#hidden-div-services").load( frontpage + "joury/register/service/services/result/spa" ,{"servicename":servicename} , function(){
			// service table is loaded
					


			$("#hidden-div-services select").attr("disabled" , " ") ;		
					
						
			$("input#select").change(function(){ // checkbox changed for services
			if($(this).attr("checked")){ // this checkbox enabled
				$(this).closest("tr").attr("id" , "current-raw") ; // give unice id for this raw
				var thisrowexist = 0 ; 
				var currentService = $("#current-raw td:first").text();
				$("#current-raw select").removeAttr("disabled") ;
				$("#hidden-div-services-selected tr").each(function(){
					$(this).attr("id" , "counted-row") ; 
					var rowService = $("#counted-row td:first").html() ; 
					if(currentService == rowService){
						alert("sorry this service selected before") ; 	
						thisrowexist = 1 ; 
					}	 
					$("#counted-row").removeAttr("id") ; 
				});
				if(thisrowexist == 1){
					$("#current-raw").remove() ; 
					$("#head-raw").remove() ; 
					return ; 	
				}	
				$("#current-raw").addClass("message ok") ; 
				if($("#hidden-div-services-selected tr").length == 1){ // show head raw
					$("#hidden-div-services-selected tr").show() ; 
				}
				$("#current-raw").appendTo("table#hidden-div-services-selected") ;
				if($("#hidden-div-services tr").length == 1){
					$("#hidden-div-services tr").hide() ; 	
				}	
				$("#current-raw input").removeAttr("disabled", " " ) ; 
				var keynumber = $("#current-raw #keynumber").val() ; 
				$("#current-raw #registerdate-" + keynumber).datetimepicker({ ampm:true ,stepMinute: 15,});	
				$("#current-raw").removeAttr("id") ;  // remove the unice id from the parent raw
				return ;
			}	//  end of this checkbox enabled
			
			// checkbox is disabled
			
				$(this).closest("tr").attr("id" , "current-raw") ; // give unice id for this raw
				$("#current-raw").removeClass("message ok") ; 
				$("#current-raw").remove() ; 
				var dynamicTableRaws = parseInt($("#hidden-div-services-selected tr").length) ;
				if(dynamicTableRaws == 1){
						$("#hidden-div-services-selected tr").hide() ; 
				}	
				$("#current-raw").removeAttr("id") ;  // remove the unice id from the parent raw						
			
			// end of checkbox is disabled
			});
		}); // end of loading the ajax service result
	}) ; // end of : form service name is changed
	
	$("#head-raw-of-selected").hide() ; 
}	