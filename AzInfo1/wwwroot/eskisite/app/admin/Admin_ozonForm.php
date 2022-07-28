<?php

class Admin_ozonForm extends CForm
{
	public $_fields = array(
		'ozon_id'=>array(
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
			'unique'=>true,
			'tabgroup'=>'Başlık',
			'tablabel'=>'TR',
		),
		'baslik_az'=>array(
			'type'=>'text',
			'label'=>'Başlık (AZ)',
			'rules'=>array(
				'required'=>'Lütfen Başlık (AZ) giriniz'
			),
			'unique'=>true,
			'tabgroup'=>'Başlık',
			'tablabel'=>'AZ',
		),
		'baslik_en'=>array(
			'type'=>'text',
			'label'=>'Başlık (EN)',
			'rules'=>array(
				'required'=>'Lütfen Başlık (EN) giriniz'
			),
			'unique'=>true,
			'tabgroup'=>'Başlık',
			'tablabel'=>'EN',
		),
		'baslik_ru'=>array(
			'type'=>'text',
			'label'=>'Başlık (RU)',
			'rules'=>array(
				'required'=>'Lütfen Başlık (RU) giriniz'
			),
			'unique'=>true,
			'tabgroup'=>'Başlık',
			'tablabel'=>'RU',
		),
		
		'simge'=>array(
			'type'=>'image',
			'label'=>'Simge',
			'rules'=>array(),
		),
		'simge2'=>array(
			'type'=>'image',
			'label'=>'Simge 2',
			'info'=>'(hover)',
			'rules'=>array(),
		),
		'resim'=>array(
			'type'=>'image',
			'label'=>'Resim',
			'rules'=>array(),
		),
		
		'aciklama_tr'=>array(
			'type'=>'cke',
			'label'=>'Açıklama (TR)',
			'rules'=>array(),
			'tabgroup'=>'Açıklama',
			'tablabel'=>'TR',
		),
		'aciklama_az'=>array(
			'type'=>'cke',
			'label'=>'Açıklama (AZ)',
			'rules'=>array(),
			'tabgroup'=>'Açıklama',
			'tablabel'=>'AZ',
		),
		'aciklama_en'=>array(
			'type'=>'cke',
			'label'=>'Açıklama (EN)',
			'rules'=>array(),
			'tabgroup'=>'Açıklama',
			'tablabel'=>'EN',
		),
		'aciklama_ru'=>array(
			'type'=>'cke',
			'label'=>'Açıklama (RU)',
			'rules'=>array(),
			'tabgroup'=>'Açıklama',
			'tablabel'=>'RU',
		),
		
		'kutu1_tr'=>array(
			'type'=>'cke',
			'label'=>'Uygulama Alanları (TR)',
			'rules'=>array(),
			'tabgroup'=>'Uygulama Alanları',
			'tablabel'=>'TR',
		),
		'kutu1_az'=>array(
			'type'=>'cke',
			'label'=>'Uygulama Alanları (AZ)',
			'rules'=>array(),
			'tabgroup'=>'Uygulama Alanları',
			'tablabel'=>'AZ',
		),
		'kutu1_en'=>array(
			'type'=>'cke',
			'label'=>'Uygulama Alanları (EN)',
			'rules'=>array(),
			'tabgroup'=>'Uygulama Alanları',
			'tablabel'=>'EN',
		),
		'kutu1_ru'=>array(
			'type'=>'cke',
			'label'=>'Uygulama Alanları (RU)',
			'rules'=>array(),
			'tabgroup'=>'Uygulama Alanları',
			'tablabel'=>'RU',
		),
		
		'kutu2_tr'=>array(
			'type'=>'cke',
			'label'=>'Yararları (TR)',
			'rules'=>array(),
			'tabgroup'=>'Yararları',
			'tablabel'=>'TR',
		),
		'kutu2_az'=>array(
			'type'=>'cke',
			'label'=>'Yararları (AZ)',
			'rules'=>array(),
			'tabgroup'=>'Yararları',
			'tablabel'=>'AZ',
		),
		'kutu2_en'=>array(
			'type'=>'cke',
			'label'=>'Yararları (EN)',
			'rules'=>array(),
			'tabgroup'=>'Yararları',
			'tablabel'=>'EN',
		),
		'kutu2_ru'=>array(
			'type'=>'cke',
			'label'=>'Yararları (RU)',
			'rules'=>array(),
			'tabgroup'=>'Yararları',
			'tablabel'=>'RU',
		),
		
		'kutu3_tr'=>array(
			'type'=>'cke',
			'label'=>'Teknik Özellikler (TR)',
			'rules'=>array(),
			'tabgroup'=>'Teknik Özellikler',
			'tablabel'=>'TR',
		),
		'kutu3_az'=>array(
			'type'=>'cke',
			'label'=>'Teknik Özellikler (AZ)',
			'rules'=>array(),
			'tabgroup'=>'Teknik Özellikler',
			'tablabel'=>'AZ',
		),
		'kutu3_en'=>array(
			'type'=>'cke',
			'label'=>'Teknik Özellikler (EN)',
			'rules'=>array(),
			'tabgroup'=>'Teknik Özellikler',
			'tablabel'=>'EN',
		),
		'kutu3_ru'=>array(
			'type'=>'cke',
			'label'=>'Teknik Özellikler (RU)',
			'rules'=>array(),
			'tabgroup'=>'Teknik Özellikler',
			'tablabel'=>'RU',
		),
		
		'link'=>array(
			'type'=>'text',
			'label'=>'Link',
			'info'=>'(Online Satış)',
			'rules'=>array(),
		),
	);
}
