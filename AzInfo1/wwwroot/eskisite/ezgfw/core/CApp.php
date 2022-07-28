<?php

class CApp
{
	public static function run()
	{				
		defined('CSS_URL') || define('CSS_URL',BASE_URL .'/css');
		defined('JS_URL')  || define('JS_URL',BASE_URL .'/js');
		
		_setAppData('config',array());
		_setAppData('css_files',array());
		_setAppData('js_files',array());
		
		// Load main config file
		CCoreHelper::loadConfig('main');
		$config = _getAppData('config',true);
		switch($config['main']['urlType'])
		{
			case 'canonical':
				$reqStr = '';
				if( isset($_SERVER['PATH_INFO']) && isset($_SERVER['ORIG_PATH_INFO']) ){
					$reqStr = $_SERVER['PATH_INFO'];
				}					
				else if( !isset($_SERVER['PATH_INFO']) && isset($_SERVER['ORIG_PATH_INFO']) ){
					$reqStr = $_SERVER['ORIG_PATH_INFO'];
				}
				else if( isset($_SERVER['PATH_INFO']) ){
					$reqStr = $_SERVER['PATH_INFO'];
				}
				$reqStr = preg_replace('/^('.str_replace('/','\/' , BASE_URL).'\/Index.php)/i','',$reqStr);
				_setAppData('requestString',$reqStr);
			break;

			case 'canonical2':
				$reqStr =  $_SERVER['REQUEST_URI'];
				$parts = explode('?',$reqStr,2);
				$reqStr = $parts[0];
				if(isset($parts[1])){
					parse_str($parts[1], $_GET);
				}
				_setAppData('requestString',$reqStr);
			break;
			
			case 'parametric':
			default:
				$reqStr = CCoreHelper::getVal($_GET[$config['main']['requestParameter']]);
				$reqStr = preg_replace('/^('.str_replace('/','\/' , BASE_URL).'\/Index.php)/i','',$reqStr);
				_setAppData('requestString', $reqStr );
		}
		
		unset($_GET[$config['main']['requestParameter']]); // to skip the following check for requestParameter
		
		try
		{
			if(isset($config['main']['allowedParameters']))
			{
				foreach($_GET as $key=>$value)
				{
					if( !in_array($key,$config['main']['allowedParameters'] ) )
					{
						CCoreHelper::show404();
					}
				}
			}				
		
			self::_dispatch(_getAppData('requestString'));
		}
		catch(CException $e)
		{
			echo $e;
		}
		catch(Exception $e)
		{
			echo $e;
		}
	}

	protected static function _dispatch($requestString)
	{
		_setAppData('active_action','');
		$request = CUrlHelper::getRequestArr($requestString,true);
		
		_setAppData('params',$request['params']);
		_setAppData('params_pure',$request['params_pure']);
		_setAppData('lang',$request['lang']);
		
		define('LANG',$request['lang']);
		
		if($request['valid'])
		{
			$config = _getAppData('config',true);
			
			// set language url variations
			
			$options = array();
			if(!empty($request['module'])){
				$options['module'] = $request['module'];
			}
			$action_str = strtolower($request['controller']). (!empty($request['action'])?'/'. strtolower( preg_replace('/^action/', '', $request['action']) )   :'');
			
			foreach($config['main']['languages'] as $l){
				_setAppData('lang_url_'.$l, CUrlHelper::getLangUrl($l,$action_str,$request['params_pure'],null,'-',$options) );
			}
			
			
			if(!empty($request['module']))
			{
				$module_dir = CFilterHelper::filterDirectoryName($request['module']);
				_setAppData('module_dir', $module_dir );
				_setAppData('module_alias', $request['module_alias'] );
				
				// get module params from app config file
				//$config = _getAppData('config',true);
				if(isset($config['main']['modules'][$request['module_alias']]['params']))
				{
					_setAppData('module_params',$config['main']['modules'][$request['module_alias']]['params']);
				}
				
				_setAppData('autoload_modules',true); // for being able to autoload external modules (modular cooperations)
				
				$init_file = APP_PATH.'/modules/'.$module_dir.'/init.php';
				if(is_file($init_file)){
					require($init_file);
				}				
			}
						
			if(!class_exists($request['controller'])){
				CCoreHelper::show404();
			}
			$Controller = new $request['controller']();
			if(method_exists($Controller,$request['action']))
			{					
				if( $Controller->_beforeAction($request['action']) !==false )
				{
					$Controller->{$request['action']}();
					$Controller->_afterAction($request['action']);
				}
				CCacheHelper::endUrlCache(); // runs if cache buffer is started in action
			}
			else
			{
				CCoreHelper::show404();
			}
						
		}
		elseif(isset($request['redirect']))
		{
			CUrlHelper::redirect($request['redirect']);
		}
		else
		{
			CCoreHelper::show404();
		}
	}
									
}
