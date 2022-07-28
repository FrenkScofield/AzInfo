<?php

/*
 * EZGFW PHP 5 framework project
 * 
 * This file should be in the base path of web site (out of the framework directory according to the following settings.)
 
 * Sample directory structure:
 * 
 * .../web_site/ezgfw/
 * .../web_site/app/
 * .../web_site/init.php (this file)
 * .../web_site/index.php (the main application running index.php script which contains these lines to run the application:

require('init.php');
CApp::run();

* 
 * .../web_site/[others: js, css etc.]
 * 
*/

// a session may be needed for some reasons (for custom porposes and also for )
if(is_file('session.php')){
	include_once('session.php');
}
if(!isset($_SESSION['_token'])){
	$_SESSION['_token'] = md5(uniqid('tkn_', true));
}

//  '../no/trailing/ending/slashes/for/dir/values'

// Application Directory
$_app_dir = 'app';

// Framework Directory
$_fw_dir = 'ezgfw';

// Media Directory
$_media_dir = 'media';


// DON'T CHANGE ANYTHING BELOW THIS LINE

$GLOBALS['_app_data'] = array();

define('DS',DIRECTORY_SEPARATOR);


$bpath = realpath(dirname(__FILE__));
if($bpath===FALSE){ // realpath function fails on windows servers
	$bpath = dirname(__FILE__);
}
define('BASE_PATH',$bpath);


define('FW_PATH',BASE_PATH.'/'.$_fw_dir);

define('APP_PATH',BASE_PATH.'/'.$_app_dir);

define('MEDIA_PATH',BASE_PATH.'/'.$_media_dir);
define('IMAGES_PATH',MEDIA_PATH.'/images');
define('FILES_PATH',MEDIA_PATH.'/files');

$base_url = dirname($_SERVER["SCRIPT_NAME"]);
$base_url = $base_url==DS?'':$base_url;

if(function_exists('_url_fix')){
	$base_url = _url_fix($base_url);
}

define('BASE_URL', $base_url);
define('MEDIA_DIR_URL', BASE_URL.'/'.$_media_dir);
define('FILES_URL', MEDIA_DIR_URL.'/files');
define('IMAGES_DIR_URL', MEDIA_DIR_URL.'/images');

if(is_file(MEDIA_PATH.'/cache/.htaccess')){
	define('IMAGES_URL', MEDIA_DIR_URL.'/cache');
}else {
	define('IMAGES_URL', BASE_URL.'/image.php?img=');
}

define('APP_URL', BASE_URL.'/'.$_app_dir); // may be used for app based urls (ie. for module client side files)

$host = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'';

define('IS_LOCALHOST',
	(
		($host=='localhost') 
		|| (strpos($host,'local.')===0)
		|| (strpos($host,'127.')===0)
		|| (strpos($host,'192.168.')===0)
	)
);

require_once(FW_PATH.'/init.php');

