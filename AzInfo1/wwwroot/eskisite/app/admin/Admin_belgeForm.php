<?php

class Admin_belgeForm extends CForm
{
	public $_fields = array(
		'belge_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		'bolum'=>array(
			'type'=>'text',
			'label'=>'Bolum',
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
