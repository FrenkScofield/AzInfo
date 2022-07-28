<?php

class Admin_mod_lang_dictForm extends CForm
{
	public $_fields = array(
		'word_id'=>array(
			'label'=>'Id',
			'type'=>'hidden'
		),
		'key'=>array(
			//'label'=>'Key (Default)',
			'label'=>'Anahtar (Varsayılan)',
			'type'=>'text',
			'unique'=>true,
			'editable'=>false,
			'rules'=>array(				
				//'required'=>'Anahtar değeri gereklidir'
			)
		),
		'tr'=>array(
			'label'=>'TR',
			'type'=>'text',			
		),		
		'az'=>array(
			'label'=>'AZ',
			'type'=>'text',			
		),	
		'en'=>array(
			'label'=>'EN',
			'type'=>'text',
		),		
		'ru'=>array(
			'label'=>'RU',
			'type'=>'text',
		)
	);	
}
