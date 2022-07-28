<?php

class ModAdminUserForm extends CForm
{
	public $_fields = array(		
		'user_id'=>array(
			'label'=>'Id',
			'type'=>'hidden'			
		),
		'confirm_status'=>array(
			'label'=>'Active',
			'type'=>'checkbox',
		),
		'group_id'=>array(
			'label'=>'Group',
			'type'=>'select',
			'related'=>'Group',
		),
		'username'=>array(
			'label'=>'Username',
			'type'=>'text',
			'rules'=>array(
				'required'=>'Username field is required.'
			),
			'unique'=>true
		),
		'email'=>array(
			'label'=>'Email',
			'type'=>'text',			
			//'unique'=>true
		),
		'password'=>array(
			'label'=>'Password',
			'type'=>'passwordSha',
		),		
		/*'signature'=>array(
			'label'=>'Signature',
			'type'=>'tinymce',			
		),*/
	);	
}
