<?php

class Admin_videoForm extends CForm
{
	public $_fields = array(
		'video_id'=>array(
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
		'baslik'=>array(
			'type'=>'text',
			'label'=>'Başlık',
			'rules'=>array(),
		),
		'resim'=>array(
			'type'=>'image',
			'label'=>'Resim',
			'rules'=>array(),
		),
		'url'=>array(
			'type'=>'text',
			'label'=>'Video url',
			'rules'=>array(),
		),

	);
}
