$(document).ready(start) ; 

function start(){
	$("#edit-date").datepicker({ changeMonth: true }) ; 
	$("a#attendance-link").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			}); 	
}	