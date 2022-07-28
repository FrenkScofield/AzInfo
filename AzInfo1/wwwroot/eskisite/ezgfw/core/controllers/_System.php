<?php

class _System extends CController
{
	public $layout='_system';
	//protected $_view_dir='_system'; // default value
	
	public function __construct()
	{
		parent::__construct();
		$this->_isModule = false;
	}
	
	public function show404()
	{
		if(is_file(APP_PATH.'/redirect_map.php')){
			require APP_PATH.'/redirect_map.php';
			
			$prefix = IS_LOCALHOST? BASE_URL .'/index.php' :'';		
			$uri =  $_SERVER['REQUEST_URI']; 

			$key = str_replace($prefix, '', $uri);
			
			if(isset($redirect_map[$key])){
				$url = $prefix . $redirect_map[$key];
				CUrlHelper::redirectUrl($url,true);
			}
		}
		
		echo $this->loadViewFile(FW_PATH.'/core/views/_system/error.php', array(
			'error_title'=>_l('404 Page not found'),
			'error'=>_l('The url you requested is invalid. Please correct the url and try again.')
		));
	}
	
	public function showError($msg,$title='An error occured')
	{
		echo $this->loadViewFile(FW_PATH.'/core/views/_system/error.php', array(
			'error_title'=>$title,
			'error'=>$msg
		));
	}
}
