<?php

class Admin_iletisim_adresForm extends CForm
{
	public $_fields = array(
		'adres_id'=>array(
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
		'adres'=>array(
			'type'=>'text',
			'label'=>'Adres',
			'rules'=>array(),
		),
		'telefon'=>array(
			'type'=>'text',
			'label'=>'Telefon',
			'rules'=>array(),
		),
		'faks'=>array(
			'type'=>'text',
			'label'=>'Faks',
			'rules'=>array(),
		),
		'enlem'=>array(
			'type'=>'float',
			'label'=>'Enlem',
			'rules'=>array(),
		),
		'boylam'=>array(
			'type'=>'float',
			'label'=>'Boylam',
			'rules'=>array(),
		),
		'harita_link'=>array(
			'type'=>'text',
			'label'=>'Harita link',
			'rules'=>array(),
		),
		'email'=>array(
			'type'=>'text',
			'label'=>'Email',
			'rules'=>array(
				'email'=>'Geçersiz email adresi'
			),
		),

	);
}
