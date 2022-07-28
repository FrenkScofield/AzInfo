<?php

class ModAdminSettingsForm extends CForm
{
	public $User = null; // User Model Obj
	
	public $_fields = array(
		'password'=>array(
			'label'=>'Password',
			'type'=>'passwordSha',
			'rules'=>array(
				'required'=>'Password field is required.'
			)
		),
		'new_password'=>array(
			'label'=>'New Password',
			'type'=>'password',
		),
		'new_password2'=>array(
			'label'=>'New Password (repeat)',
			'type'=>'password',
			'rules'=>array(
				'repeat(new_password)'=>'Password repeat is wrong.'
			)
		),
		/*'signature'=>array(
			'label'=>'Signature',
			'type'=>'tinymce',
		),*/
	);
	
	public function initModel()
	{
		if($user_id = ModAdminUserHelper::isLoggedIn() )
		{
			$this->User = new ModAdminUserModel();
			if(!$this->User->findByPk($user_id))
				die('User not found!');
		}
		else die('User id undefined!');
	}
	
	public function validate()
	{
		if($this->_validated)
		{
			$password_sha = $this->password;			
			$this->initModel();			
			$password_sha2 = $this->User->password;			
			
			if($password_sha != $password_sha2)
			{
				$this->addError(_l('Password is wrong.'));				
				$this->_validated = false;				
			}
		}
		return $this->_validated;
	}		
}
