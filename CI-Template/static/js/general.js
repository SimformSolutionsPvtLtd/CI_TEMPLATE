$(function() {
	$(".tablesorter").tablesorter();
	
	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		
		return false;
	});
	
	jQuery("#EditForm").validationEngine({promptPosition : "centerRight", scroll: true});
	
	$('.input_birthday').datepicker({
		showOn : "button",
		buttonImage : base_url + "static/images/calendar.gif",
		buttonImageOnly : true,
		dateFormat : 'mm/dd/yy',
		changeMonth : true,
		changeYear : true,
		yearRange: '1920:'
	});
	
	$('.input_date').datepicker({
		showOn : "button",
		buttonImage : base_url + "static/images/calendar.gif",
		buttonImageOnly : true,
		dateFormat : 'yy-mm-dd',
		changeMonth : true,
		changeYear : true
	});
	
	$('.input_time').timepicker({
		showOn : "button",
		buttonImage : base_url + "static/images/calendar.gif",
		buttonImageOnly : true,
		hourGrid: 4,
		minuteGrid: 10
	});
	/*
	if ($('aside#sidebar').height() < $(window).height() - 92) {
		$('aside#sidebar').height(($(window).height() - 92));
	}
	*/
	if ($('section#main').height() < $(window).height() - 92) {
		$('section#main').height(($(window).height() - 92));
	}
	
	$('.column').equalHeight();
	

	
	$(window).resize(function() {
		if ($('section#main').height() < $(window).height() - 92) {
			$('section#main').height(($(window).height() - 92));
		}
		
		$('.column').equalHeight();
		
		return;
	});
	
	show_date_time('system_time');	
	
	$(document).ready(function() {
		$(".fancybox").fancybox();
		
		$("a.fancybox-link-video").fancybox({
			'scrolling'		:	"no",
			'width'			:	400,
			'height'		:	400,
			'titleShow'		: 	false,
			'type'			:	'iframe',
			'padding'		:   0
		});
		
		$("a.fancybox-link-audio").fancybox({
			'scrolling'		:	"no",
			'width'			:	400,
			'height'		:	25,
			'titleShow'		: 	false,
			'type'			:	'iframe',
			'padding'		:   0
		});
		
		$("a.fancybox-link-location").fancybox({
			'scrolling'		:	"no",
			'width'			:	600,
			'height'		:	400,
			'titleShow'		: 	true,
			'type'			:	'iframe',
			'padding'		:   0
		});
	});
})

function find_location() {
	var iframe = '<iframe id="popup_iframe" src="'+base_url+'common/find_location.php" title="Find Location" frameborder="0" style="padding:0;"/>';
	$(iframe).dialog({
		autoOpen: true,
		modal : true,
		width : 710,
		height : 600,
		resizable : false,
		open : function(event, ui) {
			$('#popup_iframe').css("width", "700px").attr('scrolling', 'yes').attr("frameborder", 0);
		},
		close : function(event, ui) {
			$('div.ui-dialog').remove();
			$('#popup_iframe').remove();
		}
	});
}

function view_location(latitude, longitude) {
	var iframe = '<iframe id="popup_iframe" src="'+base_url+'common/view_location.php?latitude='+latitude+'&longitude='+longitude+'" title="Find Location" frameborder="0" style="padding:0;"/>';
	$(iframe).dialog({
		autoOpen: true,
		modal : true,
		width : 710,
		height : 600,
		resizable : false,
		open : function(event, ui) {
			$('#popup_iframe').css("width", "700px").attr('scrolling', 'yes').attr("frameborder", 0);
		},
		close : function(event, ui) {
			$('div.ui-dialog').remove();
			$('#popup_iframe').remove();
		}
	});
}

function send_email(user_id) {
	var iframe = '<iframe id="popup_iframe" src="'+base_url+'common/send_email.php?user_id='+user_id+'" title="Send Email" frameborder="0" style="padding:0;"/>';
	$(iframe).dialog({
		autoOpen: true,
		modal : true,
		width : 710,
		height : 400,
		resizable : false,
		open : function(event, ui) {
			$('#popup_iframe').css("width", "700px").attr('scrolling', 'no').attr("frameborder", 0);
		},
		close : function(event, ui) {
			$('div.ui-dialog').remove();
			$('#popup_iframe').remove();
		}
	});
}

function all_checkbox(all_check) {
	if (all_check.attr('checked') == 'checked') {
		$(".all_check").attr('checked', "checked");
	} else {
		$(".all_check").removeAttr('checked');
	}
}

function show_date_time(id)
{
    date = new Date;
    year = date.getFullYear();
    month = date.getMonth();
    months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
    d = date.getDate();
    day = date.getDay();
    days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    h = date.getHours();
    if(h<10)
    {
            h = "0"+h;
    }
    m = date.getMinutes();
    if(m<10)
    {
            m = "0"+m;
    }
    s = date.getSeconds();
    if(s<10)
    {
            s = "0"+s;
    }
    result = ''+days[day]+' '+months[month]+' '+d+' '+year+' '+h+':'+m+':'+s;
    document.getElementById(id).innerHTML = result;
    setTimeout('show_date_time("'+id+'");','1000');
    return true;
}



function tiny_mce_init() {
	tinyMCE.init({
		// General options
		mode : "textareas",
		editor_deselector : "mceNoEditor",
		theme : "advanced",															
		relative_urls : false,
		// Theme options
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,|,forecolor,backcolor,|,charmap,preview",
		theme_advanced_buttons3 : "tablecontrols,|,hr,insertlayer,|,insertdate,inserttime,|,code",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Drop lists for link/image/media/template dialogs
		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
}