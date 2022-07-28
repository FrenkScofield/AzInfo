<?php

class Admin_referans_kategoriForm extends CForm
{
	public $_fields = array(
		'kategori_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		'sira'=>array(
			'type'=>'integer',
			'label'=>'Sıra',
			'rules'=>array(),
		),
		'baslik_tr'=>array(
			'type'=>'text',
			'label'=>'Başlık (TR)',
			'rules'=>array(
				'required'=>'Lütfen Başlık (TR) giriniz'
			),
			'unique'=>true
		),
		'baslik_az'=>array(
			'type'=>'text',
			'label'=>'Başlık (AZ)',
			'rules'=>array(
				'required'=>'Lütfen Başlık (AZ) giriniz'
			),
			'unique'=>true
		),
		'baslik_en'=>array(
			'type'=>'text',
			'label'=>'Başlık (EN)',
			'rules'=>array(
				'required'=>'Lütfen Başlık (EN) giriniz'
			),
			'unique'=>true
		),
		'baslik_ru'=>array(
			'type'=>'text',
			'label'=>'Başlık (RU)',
			'rules'=>array(
				'required'=>'Lütfen Başlık (RU) giriniz'
			),
			'unique'=>true
		),

	);
}
