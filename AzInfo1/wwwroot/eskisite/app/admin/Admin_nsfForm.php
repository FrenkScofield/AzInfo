<?php

class Admin_nsfForm extends CForm
{
	public $_fields = array(
		'nsf_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		'sira'=>array(
			'type'=>'integer',
			'label'=>'Sıra',
			'rules'=>array(),
		),
		'isim'=>array(
			'type'=>'text',
			'label'=>'İsim',
			'rules'=>array(
				'required'=>'Lütfen İsim giriniz'
			),
		),
		'dosya'=>array(
			'type'=>'file',
			'label'=>'Dosya',
			'rules'=>array(),
		),
		'resim'=>array(
			'type'=>'image',
			'label'=>'Resim',
			'rules'=>array(),
		),

	);
}
