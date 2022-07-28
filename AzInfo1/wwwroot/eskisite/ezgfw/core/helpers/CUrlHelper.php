<?php


class CUrlHelper extends CHelper
{	
	public static function getDomain(){
		return $_SERVER["SERVER_NAME"];
	}
	
	public static function getWebUrl($rootOnly = false){
		$pageURL = 'http';
		if( isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";			
		}
		$pageURL .= "://";
		if($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"];
		}

		if(!$rootOnly){
			$pageURL .= $_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	/**
	 * css/js gibi dosyalar için dosyanın değişim zamanına göre versiyon parametresi ekleyerek url oluşturur
	 * 
	 * @param string $path
	 * @return string url 
	 * 
	 */
	public static function getAssetUrl($path){
		return BASE_URL.'/'.$path.'?v='.filemtime(BASE_PATH.'/'.$path);
	}
	
	public static function setPageUrl($url,$force=false)
	{
		_setAppData('page_url',$url);
		$current = _getAppData('requestString');
		$current = self::getUrl($current);
		if(!empty($url) && $force && $current!=$url)
		{			
			header('Location: '.$url,TRUE,301);
			exit;
		}
	}
		
	
	// ONLY FOR URL OPERATIONS ( use CCoreHelper::isModule() for class based operations) *****	
	
	public static function isModule() 
	{
		$module_dir = _getAppData('module_dir');
		return empty($module_dir) ? false : $module_dir ;
	}
	
	
	// base url is also defined in layouts as $base_url
	public static function getBaseUrl($path='')
	{		
		return BASE_URL.(!empty($path)?'/'.$path:'');
	}
	
	public static function redirectUrl($url,$permanent=false)
	{
		if($permanent){
			header('Location: '.$url,TRUE,301);
		} else {
			header('Location: '.$url);
		}
		exit;
	}
	// redirect to given request $requestString page
	public static function redirect($requestString,$permanent=false)
	{
		if($permanent){
			header('Location: '.CUrlHelper::getUrl($requestString),TRUE,301);
		} else {
			header('Location: '.CUrlHelper::getUrl($requestString));
		}
		exit;
	}
	
	public static function modRedirect($requestString,$permanent=false)
	{
		if($permanent){
			header('Location: '.CUrlHelper::getModUrl($requestString),TRUE,301);
		} else {
			header('Location: '.CUrlHelper::getModUrl($requestString));
		}
		exit;
	}
	
	public static function modXRedirect($mod,$requestString,$permanent=false)
	{
		if($permanent){
			header('Location: '.CUrlHelper::getModXUrl($mod,$requestString),TRUE,301);
		} else {
			header('Location: '.CUrlHelper::getModXUrl($mod,$requestString));
		}
		exit;
	}
	
	public static function module_listed(&$moduleName)
	{
		$config = _getAppData('config',true);
		
		if(!isset($moduleName)) return false;
		if(empty($moduleName)) return false;
		
		if(isset($config['main']['modules'][$moduleName]))
		{
			return isset($config['main']['modules'][$moduleName]['module'])? $config['main']['modules'][$moduleName]['module'] : $moduleName ;
		}
		elseif( isset($config['main']['modules']) && in_array($moduleName,$config['main']['modules']) )
		{
			return $moduleName;
		}
		else
		{
			return false;
		}		
	}
	
	public static function getSlug($str)
	{		
		$str = urldecode($str);
		$str = html_entity_decode($str,ENT_QUOTES,'utf-8');
		$str = str_replace(
			array('ö','ç','ş','ı','ğ','ü','Ö','Ç','Ş','İ','Ğ','Ü'),
			array('o','c','s','i','g','u','o','c','s','i','g','u'),
			$str
		);
		$str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
		$str = preg_replace('/[^a-zA-Z0-9]/', ' ', $str);
		$str = strtolower(trim($str));
		$str = preg_replace('/[ ]+/', '-', $str);
		return $str;
	}
    
	public static function getLangUrl($lang,$requestString=null,$params=array(),$addSlug=null,$slugLimiter='-'){
		if($requestString===null){
			return _getAppData('lang_url_'.$lang);
		}
		else {
			return CUrlHelper::getUrl($requestString,$params,$addSlug,$slugLimiter,array(
				'lang'=>$lang
			));
		}
	}
	
	public static function getModXUrl($module,$requestString,$params=array(),$addSlug=null,$slugLimiter='-')
	{
		return CUrlHelper::getUrl($requestString,$params,$addSlug,$slugLimiter,array(			
			'module'=>$module
		));
	}
	
	public static function getModUrl($requestString,$params=array(),$addSlug=null,$slugLimiter='-')
	{
		return CUrlHelper::getUrl($requestString,$params,$addSlug,$slugLimiter,array(
			'module_base'=>true
		));
	}
       
    			
	public static function getUrl($requestString,$params=array(),$addSlug=null,$slugLimiter='-',$options=array())
	{
		$url_parts = array();		
		
		$appData = _getAppData(null,true);		
		$config = & $appData['config'];		
		
		$qsStarted = false;
		
		
		if($config['main']['languageRouting'])
		{
			if(isset($options['lang'])){
				$lang = $options['lang'];
			}else {
				$lang = (isset($appData['lang']) ? $appData['lang'] :  $config['main']['defaultLanguage']);
			}
			
			switch($config['main']['urlType'])
			{
				case 'canonical':
				case 'canonical2':
					$url_parts[] = $lang;
				break;
				case 'parametric':
				default:					
					$url_parts[] = '?'.$config['main']['requestParameter'].'='.$lang;
					$qsStarted = true;
			}
		}
				
		
		isset($options['module_base']) || $options['module_base']=false;
		
		if($options['module_base'] && (CUrlHelper::isModule()) )
		{
			if($config['main']['urlType']=='parametric' && !$qsStarted)
			{				
				$url_parts[] = '?'.$config['main']['requestParameter'].'=';
				$qsStarted = true;
			}
			
			if(
				// there is no module lock defined
				!( isset($config['main']['lockToModule']) ) 
				|| // or the module to be used is unlocked for use
				(isset($config['main']['unlockedModules']) && in_array(_getAppData('module_dir'),$config['main']['unlockedModules']) )
			){	
				$url_parts[] = _getAppData('module_alias');
			}
		}
		elseif(isset($options['module']))
		{
			if($config['main']['urlType']=='parametric' && !$qsStarted)
			{
				$url_parts[] = '?'.$config['main']['requestParameter'].'=';
				$qsStarted = true;
			}		
						
			if(
				// there is no module lock defined
				!( isset($config['main']['lockToModule']) ) 
				|| // or the module to be used is unlocked for use
				(isset($config['main']['unlockedModules']) && in_array($options['module'],$config['main']['unlockedModules']) )
			)
			{			
				$url_parts[] = CCoreHelper::getModAlias($options['module']);
			}
		}
				
		switch($config['main']['urlType'])
		{
			case 'canonical':
			case 'canonical2':
				$url_parts[] = $requestString;
			break;
			case 'parametric':
			default:
				if($qsStarted) {
					$url_parts[] = $requestString;
				} else {
					$url_parts[] = '?'.$config['main']['requestParameter'].'='.$requestString;
				}
		}
		if(count($params))
		{
			foreach($params as $key=>$value)
			{
				$url_parts[] = $key;
				$url_parts[] = $value;
			}
		}

		$slug = '';
		if(!empty($addSlug))
		{
			$slug = CUrlHelper::getSlug($addSlug);
		}
		
		// Replace slug with last url part
		if(!empty($slug)){
			$last_url_part = array_pop($url_parts);
			$url_parts[] = $slug;
			$slug = $last_url_part;
		}
		
		$route_url = implode('/',$url_parts). (!empty($slug)?$slugLimiter.$slug:'') ;
		
		if($config['main']['urlType']=='canonical' || $config['main']['urlType']=='canonical2'){
			$route_url = CRouteHelper::parseReverseRoute($route_url);
		}
		
		$url_parts = array(BASE_URL);
		if($config['main']['useScriptName'])
		{
			$url_parts[] = 'index.php';
		}
		if(empty($route_url)){
			$return = implode('/',$url_parts);
			if(empty($return)){
				$return = '/';
			}
		}else {
			$url_parts[] = $route_url;
			$return = implode('/',$url_parts).$config['main']['urlExtension'];
		}
		
		if(function_exists('_url_fix')){
			$return = _url_fix($return);
		}
		
		return $return;
	}
				
	
	public static function getRequestArr($requestString,$setActiveAction=false)
	{
		/* possible request formats ( may also include a language prefix )
		 * 		module
		 * 		module/controller
		 * 		module/controller/action
		 * 		module/controller/action/param1/val1/param2/val2 ...
		 * 		controller
		 * 		controller/action
		 * 		controller/action/param1/val1/param2/val2 ...
		*/
		
		$requestString = preg_replace('/^(\/)/','',$requestString);
		//$requestString = preg_replace('/^(Index\.php)/','',$requestString);
		//$requestString = str_replace('Index.php','index.php',$requestString);
		//die($requestString);
		
		$config = _getAppData('config',true);
		$request = array(
			'valid'=>true, // wheter requestString is valid
			'lang'=>$config['main']['defaultLanguage'], // language
			'module'=>'', // module
			'module_alias'=>'', // module alias (used in url)
			'controller'=>$config['main']['defaultController'], // controller
			'action'=>'index', // action
			'params'=>array(), // parameters
			'params_pure'=>array(), // parameters (no filter applied)
		);
		
		if($config['main']['urlType']=='canonical' || $config['main']['urlType']=='canonical2'){ // parse routes
			$requestString = CRouteHelper::parseRoute($requestString);			
		}
		
		// disallow script name if its not enabled
		
		if(
			!$config['main']['useScriptName']
			&& $_SERVER['REQUEST_URI']!=DS
			&& $_SERVER['REQUEST_URI']==$_SERVER['PHP_SELF']
		)
		{
			$request['valid'] = false;
		}
			
				
		if(!empty($config['main']['urlExtension']))
		{
			$requestString_tmp = $requestString;
			$requestString = preg_replace('/('.$config['main']['urlExtension'].')$/','',$requestString);
			// the url must have the extension suffix
			
			if(!empty($requestString) && $requestString_tmp == $requestString && preg_match('/([^\/])$/',$requestString) )
			{
				$request['valid'] = false;
			}
		}		
		
		$rsArr = explode('/',$requestString);		
		
		// correction for windows servers
		if($rsArr[0]=='index.php') unset($rsArr[0]);
		
		//echo '<pre>'.print_r($rsArr,true).'</pre>'; exit;
		$rsArrPure = $rsArr;
		$rsArr = CFilterHelper::filterRequestSegments($rsArr);
		
		$_params_offset = 2;
		$_i = 0;
		
		if($config['main']['languageRouting'])
		{
			if( isset($rsArr[0]) )
			{
				if( in_array($rsArr[0],$config['main']['languages']) )
				{
					$_params_offset ++ ;
					$_i = 1;
					$request['lang'] = $rsArr[0];
				}
				else
				{
					//echo __LINE__.'<br>';
					$request['valid']=false;
				}
			}
		}
				
		// check if a module lock defined
		if( 
			isset($config['main']['lockToModule']) 
			&& !( // and the requested module is not unlocked for use in url
				isset($config['main']['unlockedModules'])
				&& in_array( CUrlHelper::module_listed($rsArr[0+$_i]) , $config['main']['unlockedModules'] )
			)
		)
		{
			//die('line:'.__LINE__);
			$request['module'] = $config['main']['lockToModule'];
			$request['module_alias'] = CCoreHelper::getModAlias($request['module']);
			if(isset($rsArr[$_i]))
			{
				$request['controller'] = $rsArr[$_i];
			}
			else
			{
				$request['controller'] = 'Main';
			}
			if(isset($rsArr[1+$_i])) $request['action'] = $rsArr[1+$_i];
			
			//die('<pre>'.print_r($request,1).'</pre>');
			
		}		
		elseif($module = CUrlHelper::module_listed($rsArr[0+$_i]))
		{
			$_params_offset ++ ;
			$request['module'] = $module;
			$request['module_alias'] = $rsArr[0+$_i];
			if(isset($rsArr[1+$_i]))
			{
				$request['controller'] = $rsArr[1+$_i];
			}
			else
			{
				$request['controller'] = 'Main'; // dont leave as the default controller of app
			}
			if(isset($rsArr[2+$_i])) $request['action'] = $rsArr[2+$_i];
		}
		else
		{
			if(isset($rsArr[0+$_i])) $request['controller'] = $rsArr[0+$_i];
			if(isset($rsArr[1+$_i])) $request['action'] = $rsArr[1+$_i];
		}
				
		for($i = $_params_offset; $i<count($rsArr); $i+=2)
		{
			$request['params'][$rsArr[$i]]= isset($rsArr[$i+1])?$rsArr[$i+1]:'';
			$request['params_pure'][$rsArrPure[$i]]= isset($rsArrPure[$i+1])?$rsArrPure[$i+1]:'';
		}
		
		
		if($setActiveAction)
		{
			_setAppData('active_action', $request['controller'].'/'.$request['action'] );
		}		
		$request['controller'] = ucfirst(strtolower($request['controller']));
		$request['action']     = 'action'.ucfirst(strtolower($request['action']));
		
		//echo '<pre>'.print_r($request,true).'</pre>'; exit;
		
		return $request;
	}
	
}
