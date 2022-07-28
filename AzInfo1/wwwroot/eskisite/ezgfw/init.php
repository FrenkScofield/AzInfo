<?php

/***** <Functions> *******/

function debug(& $var,$return=false)
{
	$str = '<pre>'.print_r($var,true).'</pre>';
	if($return)
		return $str;
	else
		echo $str;
}

function _l_html($key,$type='main'){
	return html_entity_decode(_l($key,$type));
}

function _l_default($key,$default_str='',$type='main'){
	$str = _l($key,$type);
	return ($str==$key)?$default_str:$str;
}

function _l($key,$type='main')
{
	return CUrlHelper::isModule()? _mlang($key,$type) : _lang($key,$type);
}

function _lang($key,$type='main')
{
	$appData = & $GLOBALS['_app_data'];	
	isset($appData['lang']) || ($appData['lang'] = $appData['config']['main']['defaultLanguage']);
	$lang = $appData['lang'];
	$root_key = '_lang';	
	if(!isset($appData[$root_key][$lang][$type])):
		isset($appData[$root_key]) || $appData[$root_key]=array();
		isset($appData[$root_key][$lang]) || $appData[$root_key][$lang]=array();
		isset($appData[$root_key][$lang][$type]) || $appData[$root_key][$lang][$type]=array();
		$fileName = strtolower($type).'.php';
		if(is_file(APP_PATH.'/i18n/'.$lang.'/'.$fileName))
		{
			require_once APP_PATH.'/i18n/'.$lang.'/'.$fileName;
			if(isset($_lang[$type])):
				$appData[$root_key][$lang][$type] = $_lang[$type];
			endif;
		}
	endif;
	//return isset($appData[$root_key][$lang][$type][$key])?$appData[$root_key][$lang][$type][$key]:$key;
	if(isset($appData[$root_key][$lang][$type][$key]))
	{
		return !empty($appData[$root_key][$lang][$type][$key])?$appData[$root_key][$lang][$type][$key]:$key;
	}
	else
	{
		if(function_exists('_l_fail_callback'))
		{
			_l_fail_callback($key);
		}
		return $key;
	}
}

function _mlang($key,$type='main',$module='')
{
	$appData = & $GLOBALS['_app_data'];
	$module_dir = !empty($module) ? $module: _getAppData('module_dir');	
	isset($appData['lang']) || ($appData['lang'] = $appData['config']['main']['defaultLanguage']);
	$lang = $appData['lang'];
	$root_key = '_lang_module_'.$module_dir;
	if(!isset($appData[$root_key][$lang][$type])):
		isset($appData[$root_key]) || $appData[$root_key]=array();
		isset($appData[$root_key][$lang]) || $appData[$root_key][$lang]=array();
		isset($appData[$root_key][$lang][$type]) || $appData[$root_key][$lang][$type]=array();
		$fileName = strtolower($type).'.php';
		$appData[$root_key][$lang][$type] = array();		
		if(is_file(APP_PATH.'/i18n/'.$lang.'/'.$fileName))
		{
			require APP_PATH.'/i18n/'.$lang.'/'.$fileName;
			if(isset($_lang[$type])){
				$appData[$root_key][$lang][$type] = array_merge($appData[$root_key][$lang][$type] ,$_lang[$type] );
			}
		}
		if(is_file(APP_PATH.'/modules/'.$module_dir.'/i18n/'.$lang.'/'.$fileName))
		{
			require_once APP_PATH.'/modules/'.$module_dir.'/i18n/'.$lang.'/'.$fileName;;
			if(isset($_lang[$type])){
				$appData[$root_key][$lang][$type] = array_merge($appData[$root_key][$lang][$type] ,$_lang[$type] );
			}
		}
	endif;
	//return isset($appData[$root_key][$lang][$type][$key])?$appData[$root_key][$lang][$type][$key]:$key;
	if(isset($appData[$root_key][$lang][$type][$key]))
	{
		return !empty($appData[$root_key][$lang][$type][$key])?$appData[$root_key][$lang][$type][$key]:$key;
	}
	else
	{
		if(function_exists('_l_fail_callback'))
		{
			_l_fail_callback($key);
		}
		return $key;
	}
}


function _getAppData($key=null,$return_reference=false)
{	
	if(empty($key))
	{
		return $return_reference ? ($ref = & $GLOBALS['_app_data']) : $GLOBALS['_app_data'] ;
	}
	elseif(!isset($GLOBALS['_app_data'][$key]))
	{
		return null;
	}
	else
	{		
		return $return_reference ? ($ref = & $GLOBALS['_app_data'][$key]) : $GLOBALS['_app_data'][$key] ;
	}	
}

function _setAppData($key,$value)
{
	$GLOBALS['_app_data'][$key]=$value;
	return $ref = & $GLOBALS['_app_data'][$key];
}


function getModules($config_modules=null)
{
	$modules = array();
	
	if($config_modules==null)
	{
		$config = _getAppData('config');
		if(is_array($config) && isset($config['main']['modules']))
		{
			$config_modules = $config['main']['modules'];
		}
	}
	
	if(is_array($config_modules))
	{
		foreach($config_modules as $m)
		{
			if(is_array($m)){
				$modules[] = $m['module'];
			}
			else
			{
				$modules[] = $m;
			}
		}
	}	
	return $modules;
}

if(is_callable('spl_autoload_register')){
	spl_autoload_register('__autoload');
}

function __autoload($className)
{
	$module_dir = _getAppData('module_dir');
	$isModule = !empty($module_dir);
	
	$autoload_modules = _getAppData('autoload_modules');
	
	$modules = getModules();
				
	$paths = array();
	
	if(strpos($className,'Module_')===0)
	{
		$dir = strtolower(str_replace('Module_','',$className)).'/';		
		$paths[] = APP_PATH.'/modules/'.$dir;
	}	
	elseif(strpos($className,'Plugin_')===0)
	{
		$dir = strtolower(str_replace('Plugin_','',$className)).'/';
		if($isModule)
		{
			$paths[] = APP_PATH.'/modules/'.$module_dir.'/plugins/'.$dir;
		}
		$paths[] = APP_PATH.'/plugins/'.$dir;
		$paths[] = FW_PATH.'/plugins/'.$dir;
		if($autoload_modules)
		{
			foreach($modules as $mod)
			{
				$paths[] = APP_PATH.'/modules/'.$mod.'/plugins/'.$dir;
			}
		}
	}
	elseif(strpos($className,'Field_')===0)
	{
		if($isModule)
		{
			$paths[] = APP_PATH.'/modules/'.$module_dir.'/fields/';
		}		
		$paths[] = APP_PATH.'/fields/';
		$paths[] = FW_PATH.'/core/fields/';
		if($autoload_modules)
		{
			foreach($modules as $mod)
			{
				$paths[] = APP_PATH.'/modules/'.$mod.'/fields/';
			}
		}
	}
	elseif(strpos($className,'Admin_')===0)
	{
		$mod = strtolower(str_replace('Admin_','',$className));
		$paths[] = APP_PATH.'/modules/'.$mod.'/admin/';
		
		if($isModule)
		{
			$paths[] = APP_PATH.'/modules/'.$module_dir.'/admin/';
		}
		$paths[] = APP_PATH.'/admin/';
		if($autoload_modules)
		{
			foreach($modules as $mod)
			{
				$paths[] = APP_PATH.'/modules/'.$mod.'/admin/';
			}
		}
	}
	else
	{
		if($isModule)
		{
			$paths[] = APP_PATH.'/modules/'.$module_dir.'/controllers/';			
			$paths[] = APP_PATH.'/modules/'.$module_dir.'/models/';
			$paths[] = APP_PATH.'/modules/'.$module_dir.'/forms/';
			$paths[] = APP_PATH.'/modules/'.$module_dir.'/helpers/';
			$paths[] = APP_PATH.'/modules/'.$module_dir.'/widgets/';
		}
		$paths[] = FW_PATH.'/core/';
		$paths[] = FW_PATH.'/core/helpers/';
		
		$paths[] = APP_PATH.'/controllers/';		
		
		$paths[] = FW_PATH.'/core/controllers/';
		
		$paths[] = APP_PATH.'/models/';
		$paths[] = APP_PATH.'/forms/';
		$paths[] = APP_PATH.'/helpers/';
		$paths[] = APP_PATH.'/widgets/';
		
		if($autoload_modules || strpos($className,'Mod')===0)
		{
			foreach($modules as $mod)
			{
				$paths[] = APP_PATH.'/modules/'.$mod.'/controllers/';			
				$paths[] = APP_PATH.'/modules/'.$mod.'/models/';
				$paths[] = APP_PATH.'/modules/'.$mod.'/forms/';
				$paths[] = APP_PATH.'/modules/'.$mod.'/helpers/';
				$paths[] = APP_PATH.'/modules/'.$mod.'/widgets/';
			}
		}
	}
		
	$file = $className .'.php';
	
	$paths = array_unique($paths);
	
	foreach($paths as $path)
	{
		
		$include = $path.$file;		
		if(is_file($include))
		{				
			require_once $include;
			return true;
		}
	}		
	return false;
}

function _shut_down()
{
	$last_error = error_get_last();
	if(is_array($last_error) && ($last_error['type'] === E_ERROR || $last_error['type'] === E_USER_ERROR) )
	{
		_userErrorHandler($last_error['type'],$last_error['message'],$last_error['file'],$last_error['line'],array());		
	}
}


function _userErrorHandler($errno, $errmsg, $filename, $linenum, $vars) 
{
    $logErrors = _getAppData('logErrors');
	
	if($logErrors===false){
		return;
	}
	
	$is_localhost = _getAppData('is_localhost');
    
    // timestamp for the error entry
    $dt = date("Y-m-d H:i:s (T)");

    // define an assoc array of error string
    // in reality the only entries we should
    // consider are E_WARNING, E_NOTICE, E_USER_ERROR,
    // E_USER_WARNING and E_USER_NOTICE
    $errortype = array (
		E_ERROR              => 'Error',
		E_WARNING            => 'Warning',
		E_PARSE              => 'Parsing Error',
		E_NOTICE             => 'Notice',
		E_CORE_ERROR         => 'Core Error',
		E_CORE_WARNING       => 'Core Warning',
		E_COMPILE_ERROR      => 'Compile Error',
		E_COMPILE_WARNING    => 'Compile Warning',
		E_USER_ERROR         => 'User Error',
		E_USER_WARNING       => 'User Warning',
		E_USER_NOTICE        => 'User Notice',
		E_STRICT             => 'Runtime Notice',
		E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
    );
    // set of errors for which a var trace will be saved
    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
    
    if($is_localhost)
    {
		$debug_backtrace = debug_backtrace();
		foreach($debug_backtrace as $key=>$row)
		{
			unset($debug_backtrace[$key]['args']);
			unset($debug_backtrace[$key]['object']);
		}
		
		$dbg = print_r(array_reverse($debug_backtrace),true);
	}
    
    
    $err = "<error>\n";
    $err .= "\t<dt>" . $dt . "</dt>\n";
    $err .= "\t<no>" . $errno . "</no>\n";
    $err .= "\t<type>" . (isset($errortype[$errno])?$errortype[$errno]:'') . "</type>\n";
    $err .= "\t<msg>" . $errmsg . "</msg>\n";
    $err .= "\t<file>" . $filename . "</file>\n";
    $err .= "\t<line>" . $linenum . "</line>\n";
    $err .= "\t<url>" . ((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on')?'https':'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] . "</url>\n";
    if($is_localhost)
    {
		$err .= "\t<debug>" . $dbg . "</debug>\n";
	}
	
	/*
    if(in_array($errno, $user_errors))
    {
        $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
    }*/
    $err .= "</error>\n\n";
    
    @error_log($err, 3, APP_PATH.'/log/error.log');
    
    if($GLOBALS['_app_data']['is_localhost'])
	{
		echo '<pre>'.htmlspecialchars($err).'</pre>';
	}
}

/***** </Functions> *******/

_setAppData('requestMt',microtime(true));

$host = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'';

//$GLOBALS['_app_data']['is_localhost'] = ($host=='localhost') || (strpos($host,'127.')===0) || (strpos($host,'192.168.')===0);
$GLOBALS['_app_data']['is_localhost'] = IS_LOCALHOST;

if(function_exists('ob_gzhandler') && !ini_get('zlib.output_compression'))
	ob_start('ob_gzhandler');
else
	ob_start();


error_reporting( $GLOBALS['_app_data']['is_localhost']?E_ALL:0 );

//error_reporting(E_ALL);

set_error_handler('_userErrorHandler',E_ALL);

register_shutdown_function('_shut_down');

if(get_magic_quotes_gpc())
{
	foreach(array('_GET','_POST','_COOKIE') as $var)
	{
		$data_arr = & $$var;
		if(isset($data_arr) && is_array($data_arr)){
			foreach($data_arr as $name=>$value)
			{
				if(!is_array($data_arr[$name]))
				{
					$data_arr[$name] = stripslashes($data_arr[$name]);
				}
			}
		}
	}	
}
