<?php

class ModAdminUserLoginForm extends CForm
{
	public $_fields = array(
		'user'=>array(
			'label'=>'Username',
			'rules'=>array(
				'required'=>'Username field is required.'
			)
		),
		'password'=>array(
			'label'=>'Password',
			'rules'=>array(
				'required'=>'Password field is required.'
			)
		),
		'captcha_code'=>array(
			'label'=>'Confirm code',
			'rules'=>array()
		)
	);
	
	
	public function validate()
	{
		parent::validate();
		
		$mod_params = CCoreHelper::getModXParams('mod_admin');
		$login_captcha = isset($mod_params['login_captcha'])?$mod_params['login_captcha']:true;
		
		// captcha check
		if($login_captcha && !_getAppData('is_localhost') && $this->_validated){
			require ASSET_PATH.'/secureimage/securimage.php';
			$image = new Securimage();
			
			if( ! $image->check($this->captcha_code) ){
				$this->_validated = false;
				$this->addError(_l('Confirm code is wrong.'));
			}
		}
		
		if($this->_validated){
		
			$model = new ModAdminUserModel();
			
			$ok = false;
						
			if($model->find(array('username'=>$this->user)))
			{				
				$ok = ($model->confirm_status==1 && $model->password==sha1($this->password));
			}
			
			if($ok)
			{
				$this->_validated = true;
				ModAdminUserHelper::loginUser($model);
			}
			else
			{
				$this->_validated = false;
				$this->addError(_l('Login failed'));
			}
		}
		return $this->_validated;
	}
	
}
