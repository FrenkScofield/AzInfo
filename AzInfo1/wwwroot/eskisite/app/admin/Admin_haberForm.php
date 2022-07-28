<?php

class Admin_haberForm extends CForm
{
	public $_fields = array(
		'haber_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		'tarih'=>array(
			'type'=>'date',
			'label'=>'Tarih',
			'rules'=>array(
				'required'=>'Lütfen Tarih giriniz'
			),
		),
		
		'baslik_tr'=>array(
			'type'=>'text',
			'label'=>'Başlık (TR)',
			'rules'=>array(
				'required'=>'Lütfen Başlık (TR) giriniz'
			),
			'tabgroup'=>'Başlık',
			'tablabel'=>'TR',
		),
		'baslik_az'=>array(
			'type'=>'text',
			'label'=>'Başlık (AZ)',
			'rules'=>array(
				'required'=>'Lütfen Başlık (AZ) giriniz'
			),
			'tabgroup'=>'Başlık',
			'tablabel'=>'AZ',
		),
		'baslik_en'=>array(
			'type'=>'text',
			'label'=>'Başlık (EN)',
			'rules'=>array(
				'required'=>'Lütfen Başlık (EN) giriniz'
			),			
			'tabgroup'=>'Başlık',
			'tablabel'=>'EN',
		),
		'baslik_ru'=>array(
			'type'=>'text',
			'label'=>'Başlık (RU)',
			'rules'=>array(
				'required'=>'Lütfen Başlık (RU) giriniz'
			),			
			'tabgroup'=>'Başlık',
			'tablabel'=>'RU',
		),
				
		'aciklama_tr'=>array(
			'type'=>'textarea',
			'label'=>'Açıklama (TR)',
			'rules'=>array(),
			'tabgroup'=>'Açıklama',
			'tablabel'=>'TR',
		),
		'aciklama_az'=>array(
			'type'=>'textarea',
			'label'=>'Açıklama (AZ)',
			'rules'=>array(),
			'tabgroup'=>'Açıklama',
			'tablabel'=>'AZ',
		),
		'aciklama_en'=>array(
			'type'=>'textarea',
			'label'=>'Açıklama (EN)',
			'rules'=>array(),
			'tabgroup'=>'Açıklama',
			'tablabel'=>'EN',
		),
		'aciklama_ru'=>array(
			'type'=>'textarea',
			'label'=>'Açıklama (RU)',
			'rules'=>array(),
			'tabgroup'=>'Açıklama',
			'tablabel'=>'RU',
		),
		
		'resimler'=>array(
			'type'=>'images',
			'label'=>'Resimler',
			'rules'=>array(),
		),

	);
}
