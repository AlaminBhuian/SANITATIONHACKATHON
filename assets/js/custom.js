$(function(){
	//tooltip
	$(".tooltip").easyTooltip();
	
	
	$(".close").click(
		function () {
			$(this).fadeTo(400, 0, function () { // Links with the class "close" will close parent
				$(this).slideUp(400);
			});
		return false;
		}
	);
	
	
	//sortable, portlets
	$(".column").sortable({
		connectWith: '.column'
	});
	
	$(".sort").sortable({
		connectWith: '.sort'
	});
	
	
	$(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
		.find(".portlet-header")
		.addClass("ui-widget-header ui-corner-all")
		.prepend('<span class="ui-icon ui-icon-circle-arrow-s"></span>')
		.end()
		.find(".portlet-content");
	
	$(".portlet-header .ui-icon").click(function() {
		$(this).toggleClass("ui-icon-minusthick");
		$(this).parents(".portlet:first").find(".portlet-content").toggle();
	});
	
	$(".column").disableSelection();
	
				
	//hover states on the static widgets
	$('#dialog_link, ul#icons li').hover(
		function() { $(this).addClass('ui-state-hover'); }, 
		function() { $(this).removeClass('ui-state-hover'); }
	);
	
	
	$(".delete-row-data").click(function() { 
		if(confirm('Are you sure you want to delete?'))
		{
			return true;
		} else {
			return false;
		}
	});
	
	$(".datePicCal").bind("focus click", function(e){	
		var pickerOpts = {
			dateFormat:"dd-mm-yy",
			showOn: "button",
			buttonImage: "assets/images/icons/cal.gif",
			buttonImageOnly: true
		};
		$(this).datepicker(pickerOpts);
	});

	
	// hide message after 15 sec
	var defaultmessagedisplay = 15000;    
    //$('.msg-success').fadeIn('slow');
    setTimeout(function() { $('.msg-success').fadeTo(400, 0, function () { $(this).slideUp(400); }); }, defaultmessagedisplay); 
	

});
			
	