<?php
header('Content-type:text/javascript;charset=utf8;');

if(function_exists('ob_gzhandler') && !ini_get('zlib.output_compression'))
	ob_start('ob_gzhandler');
else
	ob_start();

$list = array(
	//'jquery-1.4.3.min.js',
	'jquery-1.7.1.min.js',
	'lib.js',
	'jquery.bgiframe.min.js',
	'jquery.positionBy.js',
	'jquery.blockUI.js',
	//'jquery.hotkeys.js',
	'jquery-ui-1.8.5.custom.min.js',
	'jquery.ui.datepicker-tr.js',
	'jquery.maskedinput-1.2.2.min.js',
	'jquery.dataTables.min.js',
	'jquery.form.js',
	'jnotify/jquery.jnotify.js',
	'tiny_mce/jquery.tinymce.js',
	'jquery.fileupload.js',
	'plupload/js/plupload.full.js',
	'fancybox/jquery.easing-1.3.pack.js',
	'fancybox/jquery.mousewheel-3.0.4.pack.js',
	'fancybox/jquery.fancybox-1.3.4.pack.js',
	'jdMenu/jquery.jdMenu.js',
	'mapinput/jquery.mapinput.js',
);

foreach($list as $file)
{
	echo file_get_contents($file)."\n;\n";
}
?>

$(function(){
	// notify
	$('#StatusBar').jnotifyInizialize({
		oneAtTime: false
	});
	/*
	$('#Notification')
		.jnotifyInizialize({
			oneAtTime: false,
			appendType: 'append'
		})
		.css({ 'position': 'absolute',
			'marginTop': '20px',
			'right': '20px',
			'width': '250px',
			'z-index': '9999'
		});
	*/
});
