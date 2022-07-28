<?php

class CCoreHelper extends CHelper
{
	public static function getModAlias($mod)
    {
		$config = _getAppData('config');
		if(is_array($config) && isset($config['main']['modules']))
		{
			$config_modules = $config['main']['modules'];
			if(is_array($config_modules))
			{
				foreach($config_modules as $alias=>$m)
				{
					if(is_array($m) && isset($m['module']) && $m['module']==$mod){
						return $alias;
					}
					elseif($m==$mod)
					{
						return $mod;
					}
				}
			}
		}
		return false;
	}	
	
	public static function isModule(& $class)
	{
		$_module = CCoreHelper::getVal($class->_module);
		return empty($_module)? false : $_module;
	}
		
	public static function setDefault(&$var, $default=null)
	{
		return !isset($var) ? ($var=$default) : $var ;
	}
	
	public static function getVal(&$var, $default=null)
	{
		return isset($var)?$var:$default;
	}
	
	public static function getIdParam($param,$limiter='-')
	{
		$id = CCoreHelper::getParam($param,$limiter);
		$parts = explode($limiter, $id);
		$id = array_pop($parts);
		$id = CFilterHelper::validIdParam($id);
		return $id;
	}
	
	public static function getPageParam($varName='p',$src='GET'){
		$req = & $_GET;
		if($src=='POST'){
			$req = & $_POST;
		}
		$p = isset($req[$varName])?intval($req[$varName]):1;
		$p>1 || $p=1;
		return $p;
	}
	
	// limiter is for separating real value and slug string
	public static function getParam($param,$limiter = null)
	{
		$appData = _getAppData(null,true);
		$return =  isset($appData['params'][$param])?$appData['params'][$param]:null;
		if(!empty($limiter))
		{
			$parts = explode($limiter,$return);
			$return = array_pop($parts);
		}
		return $return;
	}
	
	// get unfiltered parameter value
	public static function getParamPure($param,$limiter = null) 
	{
		$appData = _getAppData(null,true);
		$return =  isset($appData['params_pure'][$param])?$appData['params_pure'][$param]:null;
		if(!empty($limiter))
		{
			$parts = explode($limiter,$return,2);
			$return = $parts[0];
		}
		return $return;
	}
	
	public static function registerJs($files)
	{
		if(!is_array($files))
		{
			$files = explode(',',$files);
		}
		_setAppData('js_files', array_unique(array_merge(_getAppData('js_files'),$files)));
	}
	
	public static function registerCss($files)
	{
		if(!is_array($files))
		{
			$files = explode(',',$files);
		}		
		_setAppData('css_files', array_unique(array_merge(_getAppData('css_files'),$files)));
	}
		
	public static function getConfig($configName,$fileName='')
	{
		if(empty($fileName))
		{
			$fileName = strtolower($configName);
		}
		$domain = CUrlHelper::getDomain();
		if(is_file(APP_PATH.'/config/'.$domain.'/'.$fileName.'.php')){
			require APP_PATH.'/config/'.$domain.'/'.$fileName.'.php';
		}
		else {
			require APP_PATH.'/config/'.$fileName.'.php';
		}
		
		return $_config[$configName];
	}
	
	public static function getModParams()
	{
		$params = _getAppData('module_params');
		return is_array($params) ? $params : array();
	}
	public static function getModXParams($mod)
	{
		$config = _getAppData('config',true);
		$mods_arr = $config['main']['modules'];
		// find params of this module
		$params = array();
		foreach($mods_arr as $alias=>$mod_data)
		{
			$mod_name = isset($mod_data['module'])?$mod_data['module']:$alias;
			if($mod_name==$mod)
			{
				$params = isset($mod_data['params'])?$mod_data['params']:array();
				break;
			}
		}
		return $params;
	}
	
	public static function getModConfig($configName,$fileName='',$module_dir='')
	{
		if(empty($module_dir))
		{
			$module_dir = CUrlHelper::isModule();
		}
		
		if(empty($fileName))
		{
			$fileName = strtolower($configName);
		}
		
		$path = APP_PATH.'/modules/'.$module_dir.'/config/'.$fileName.'.php';
		if(is_file($path))
		{
			require($path);
			return $_config[$configName];
		}
		else
		{
			return array();
			//return CCoreHelper::getConfig($configName,$fileName);
		}
	}
			
	public static function loadConfig($configName)
	{
		$domain = CUrlHelper::getDomain();
		if(is_file(APP_PATH.'/config/'.$domain.'/'.$configName.'.php')){
			require APP_PATH.'/config/'.$domain.'/'.$configName.'.php';
		}
		else {
			require APP_PATH.'/config/'.$configName.'.php';
		}		
		_setAppData('config', array_merge( _getAppData('config'), $_config));
	}
	
	public static function loadConfigCallback($configName){
		if(is_file(APP_PATH.'/config/'.$configName.'_callback.php')){
			require(APP_PATH.'/config/'.$configName.'_callback.php');
		}
	}
		
	public static function activeAction($compare=null)
	{
		$activeAction = _getAppData('active_action');
		return ($compare!==null) ? strpos($compare,$activeAction)===0 : $activeAction ;
	}
	
	public static function show404()
	{
		header('X-Robots-Tag: noindex', true);
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		
		if(is_file(BASE_PATH.'/404.html')){
			echo file_get_contents(BASE_PATH.'/404.html');
			exit;
		}
		else if(method_exists('_System', 'show404')){
			$sys = new _System();
			$sys->show404();
			exit;
		}else {
			throw new CException(_l('Page not found!'),404);	
		}
	}
	
	public static function showError($msg,$title='An error occured')
	{
		header('X-Robots-Tag: noindex', true);
		$system = new _System();
		$system->showError($msg,$title);
		exit;
	}
	
	public static function getUserIp()
	{
		return isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'127.0.0.1';
	}
	
	
	public static function initToken(){ // aynı şekilde /init.php içinde de tanımlanıyor
		if(!isset($_SESSION['_token'])){
			$_SESSION['_token'] = md5(uniqid('tkn_', true));
		}
	}
	public static function checkToken($inputValue='')
	{
		self::initToken();
		if(empty($inputValue) && isset($_POST['_token'])){
			$inputValue = $_POST['_token'];
		}
		return ($inputValue==$_SESSION['_token']);
	}
	public static function getTokenInput()
	{		
		self::initToken();
		return '<input type="hidden" name="_token" value="'.$_SESSION['_token'].'">';
	}
	public static function tokenInput()
	{		
		self::initToken();
		?><input type="hidden" name="_token" value="<?= $_SESSION['_token'] ?>"><?php
	}
	
}
