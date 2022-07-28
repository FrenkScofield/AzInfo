<?php

class Admin_bannerForm extends CForm
{
	public $_fields = array(
		'banner_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		'sira'=>array(
			'type'=>'integer',
			'label'=>'Sıra',
			'rules'=>array(),
		),
		'dil'=>array(
			'type'=>'lang',
			'label'=>'Dil',
			'rules'=>array(
				'required'=>'Lütfen dil seçiniz'
			),
		),
		'resim'=>array(
			'type'=>'image',
			'label'=>'Resim',
			'rules'=>array(),
		),

	);
}
