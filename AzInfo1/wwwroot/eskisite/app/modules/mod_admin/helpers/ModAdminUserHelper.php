<?php

class ModAdminUserHelper extends CHelper
{
	public static function initToken($renew=false){
		if(!isset($_SESSION['mod_admin_token']) || $renew){
			$_SESSION['mod_admin_token'] = md5(uniqid('mod_admin_', true));
		}
	}
	public static function checkToken($inputValue='')
	{
		self::initToken();
		
		if(empty($inputValue) && isset($_POST['_token'])){
			$inputValue = $_POST['_token'];
		}
		
		if(empty($inputValue) && isset($_GET['_token'])){
			$inputValue = $_GET['_token'];
		}
		
		return ($inputValue==$_SESSION['mod_admin_token']);
	}
	
	public static function requireToken($alert_type='notify')
	{
		if(self::checkToken()){
			return true;
		}
		
		$error = _mlang('Invalid token!','main','mod_admin');
		
		switch($alert_type)
		{
			case 'notify':
				echo '<script type="text/javascript">notify("'.$error.'","error");</script>';
				die();
			break;
			default:
				die($error);
		}
	}
	
	
	public static function isLoggedIn()
	{
		return isset($_SESSION['mod_admin']['user']['user_id'])? $_SESSION['mod_admin']['user']['user_id'] : false;
	}
	
	// Assume user_id:1 as Super User to grant full access regardless of the group it belongs to
	public static function isSuperUser(){
		return ( isset($_SESSION['mod_admin']['user']['user_id']) && $_SESSION['mod_admin']['user']['user_id']==1 ) ;
	}
	
	public static function logout()
	{
		unset($_SESSION['mod_admin']['user']);		
		self::initToken(true);
	}
	
	public static function loginUser($user)
	{		
		self::initToken(); // burada true yaparsak menü yenileme işlevi çalıştığında token geçersiz oluyor
		
		$_SESSION['mod_admin'] = array();
		$_SESSION['mod_admin']['user'] = array();
		$_SESSION['mod_admin']['user']['user_id'] = $user->user_id;
		$_SESSION['mod_admin']['user']['username'] = $user->username;
		$_SESSION['mod_admin']['user']['email'] = $user->email;
		$_SESSION['mod_admin']['user']['group_id'] = $user->group_id;
		$_SESSION['mod_admin']['user']['demo_mode'] = $user->Group->demo_mode=='1'?true:false;
		$perms = @unserialize($user->Group->permissions);
		$perms = is_array($perms)?$perms:array();		
		$_SESSION['mod_admin']['user']['permissions'] = $perms;
	}
	
	public static function refreshData()
	{
		if($user_id=self::isLoggedIn())
		{
			$model = new ModAdminUserModel();
			if($model->findByPk($user_id))
			{
				self::loginUser($model);				
			}
		}		
	}
	
	public static function requireNotDemoUser(){
		if(self::isDemoUser())
		{
			$error = _mlang('You are not allowed to make changes in demo mode!','main','mod_admin');
			echo '<script type="text/javascript">notify("'.$error.'","error");</script>';
			die();
		}
	}
	
	public static function requireAllow($alert_type='notify',$action=null,$mod=null)
	{
		if(!self::isAllowed($action,$mod))
		{
			$error = _mlang('You are not authorized to perform this action!','main','mod_admin');
			switch($alert_type)
			{
				case 'notify':
					echo '<script type="text/javascript">notify("'.$error.'","error");</script>';
					die();
				break;
				default:
					die($error);
			}
		}
	}
	
	public static function isDemoUser(){
		return (isset($_SESSION['mod_admin']['user']['demo_mode']) && $_SESSION['mod_admin']['user']['demo_mode']);
	}
	
	public static function isAllowed($action=null,$mod=null)
	{
		if(self::isSuperUser()){
			return true;
		}
		elseif(self::isLoggedIn())
		{
			$perms = isset($_SESSION['mod_admin']['user']['permissions'])?$_SESSION['mod_admin']['user']['permissions']:array();
			if(empty($mod)) $mod = _getAppData('module_dir');
			if(empty($action)) $action = _getAppData('active_action');
			
			// admin_abc/editOne şeklindeki işlemlerin yetki kontrolü için editOne yerine edit kullan	
			$action = str_replace('/editOne', '/edit', $action);
			
			$key_parts = array();
			foreach(array($mod,$action) as $k)
			{
				if(!empty($k))
					$key_parts[] = $k;
			}
			$key = implode('/',$key_parts);			
			return in_array($key,$perms);
		}
		return false;
	}
		
	
	public static function requireLogin($alert='')
	{
		if(!self::isLoggedIn())
		{
			if(!empty($alert))
			{
				$_SESSION['mod_admin']['alert'] = $alert;
			}
			
			if(isset($_GET['xhr']))
			{
				$url = CUrlHelper::getModXUrl('mod_admin','user/login');
				?><script type="text/javascript">document.location.href='<?=$url?>';</script><?php 
			}
			else
			{
				CUrlHelper::modXRedirect('mod_admin','user/login');
			}
		}
	}
	
	public static function getSignature(){		
		$user_id = self::isLoggedIn();
		$model = new ModAdminUserModel();
		if($model->findByPk($user_id)){
			return $model->signature;
		}
		else return '';
	}
}
