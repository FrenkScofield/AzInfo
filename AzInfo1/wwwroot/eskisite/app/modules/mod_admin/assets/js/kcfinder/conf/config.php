<?php

define('BASE_PATH2',realpath(dirname(__FILE__).'/../../../../../../..'));

//echo BASE_PATH2; die();

require_once(BASE_PATH2.'/init.php');
require_once(BASE_PATH2.'/session.php');

$base_url2 = dirname($_SERVER["SCRIPT_NAME"]);

$remove = 'app/modules/mod_admin/assets/js/kcfinder';
$base_url2 = str_replace($remove,'',$base_url2);
//echo $base_url2; die();

$base_url2 = $base_url2==DS?'':$base_url2;
$base_url2 = preg_replace('#\/$#','',$base_url2);
define('BASE_URL2', $base_url2);

//echo BASE_URL2; die();

$isLoggedin = isset($_SESSION['mod_admin']['user']['user_id'])?true:false;

$_SESSION['KCFINDER']['uploadURL'] = BASE_URL2.'/media';
$_SESSION['KCFINDER']['uploadDir'] = BASE_PATH2.'/media';


/** This file is part of KCFinder project
  *
  *      @desc Base configuration file
  *   @package KCFinder
  *   @version 3.12
  *    @author Pavel Tzonkov <sunhater@sunhater.com>
  * @copyright 2010-2014 KCFinder Project
  *   @license http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
  *      @link http://kcfinder.sunhater.com
  */

/* IMPORTANT!!! Do not comment or remove uncommented settings in this file
   even if you are using session configuration.
   See http://kcfinder.sunhater.com/install for setting descriptions */

$return =  array(

// GENERAL SETTINGS

    'disabled' => $isLoggedin?false:true,
    'uploadURL' => "upload",
    'uploadDir' => "",
    'theme' => "default",

    'types' => array(

    // (F)CKEditor types
        'files'   =>  "",
        'flash'   =>  "swf",
        'images'  =>  "*img",

    // TinyMCE types
        'file'    =>  "",
        'media'   =>  "swf flv avi mpg mpeg qt mov wmv asf rm",
        'image'   =>  "*img",
    ),


// IMAGE SETTINGS

    'imageDriversPriority' => "imagick gmagick gd",
    'jpegQuality' => 90,
    'thumbsDir' => ".thumbs",

    'maxImageWidth' => 0,
    'maxImageHeight' => 0,

    'thumbWidth' => 100,
    'thumbHeight' => 100,

    'watermark' => "",


// DISABLE / ENABLE SETTINGS

    'denyZipDownload' => false,
    'denyUpdateCheck' => false,
    'denyExtensionRename' => false,


// PERMISSION SETTINGS

    'dirPerms' => 0755,
    'filePerms' => 0644,

    'access' => array(

        'files' => array(
            'upload' => true,
            'delete' => true,
            'copy'   => true,
            'move'   => true,
            'rename' => true
        ),

        'dirs' => array(
            'create' => true,
            'delete' => true,
            'rename' => true
        )
    ),

    'deniedExts' => "exe com msi bat cgi pl php phps phtml php3 php4 php5 php6 py pyc pyo pcgi pcgi3 pcgi4 pcgi5 pchi6",


// MISC SETTINGS

    'filenameChangeChars' => array(/*
        ' ' => "_",
        ':' => "."
    */),

    'dirnameChangeChars' => array(/*
        ' ' => "_",
        ':' => "."
    */),

    'mime_magic' => "",

    'cookieDomain' => "",
    'cookiePath' => "",
    'cookiePrefix' => 'KCFINDER_',


// THE FOLLOWING SETTINGS CANNOT BE OVERRIDED WITH SESSION SETTINGS

    '_sessionVar' => "KCFINDER",
    '_check4htaccess' => false,
    '_normalizeFilenames' => false,
    '_dropUploadMaxFilesize' => 10485760,
    //'_tinyMCEPath' => "/tiny_mce",
    //'_cssMinCmd' => "java -jar /path/to/yuicompressor.jar --type css {file}",
    //'_jsMinCmd' => "java -jar /path/to/yuicompressor.jar --type js {file}",
);
//debug($return); die();
return $return;
