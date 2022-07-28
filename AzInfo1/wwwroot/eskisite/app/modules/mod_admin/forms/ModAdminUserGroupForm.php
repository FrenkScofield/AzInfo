<?php

class ModAdminUserGroupForm extends CForm
{
	public $_fields = array(		
		'group_id'=>array(
			'label'=>'Id',
			'type'=>'hidden'			
		),		
		'name'=>array(
			'label'=>'Name',
			'type'=>'text',
			'rules'=>array(
				'required'=>'Group name field is required.'
			),
			'unique'=>true
		),
		'demo_mode'=>array(
			'label'=>'Demo mode',
			'type'=>'checkbox',			
		),
		'permissions'=>array(
			'label'=>'Permissions',
			'type'=>'permissions',
			'rules'=>array(				
			),
		),
	);
	
	public function createFields() {
		$params = CCoreHelper::getModXParams('mod_admin');
		$allow_demo_mode = isset($params['allow_demo_mode'])?$params['allow_demo_mode']:false;
		
		if(!$allow_demo_mode){
			unset($this->_fields['demo_mode']);
		}
		
		parent::createFields();
	}
}
