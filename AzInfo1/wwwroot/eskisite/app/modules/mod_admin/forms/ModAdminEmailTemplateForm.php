<?php

class ModAdminEmailTemplateForm extends CForm
{
	public $_fields = array(		
		'template_id'=>array(
			'label'=>'Id',
			'type'=>'hidden'
		),		
		'order'=>array(
			'label'=>'Order',
			'type'=>'integer'
		),
		'title'=>array(
			'label'=>'Title',
			'type'=>'text',
			'rules'=>array(
				'required'=>'Title is required.'
			)
		),
		'content'=>array(
			'label'=>'Content',
			'type'=>'tinymce',
			'rules'=>array()
		),		
	);	
}
