tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	editor_selector : "tinyMCE",
	skin : "o2k7",
	skin_variant : "silver",
	dialog_type : "modal",
	plugins : "inlinepopups,table,save,advhr,advimage,advlink,searchreplace,paste,directionality,media",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
});

function toggleEditor(id) {
	if (!tinyMCE.get(id))
		tinyMCE.execCommand('mceAddControl', false, id);
	else
		tinyMCE.execCommand('mceRemoveControl', false, id);
}