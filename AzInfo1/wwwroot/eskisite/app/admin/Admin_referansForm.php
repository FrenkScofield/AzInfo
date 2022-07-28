<?php

class Admin_referansForm extends CForm
{
	public $_fields = array(
		'referans_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		'kategori_id'=>array(
			'type'=>'select',
			'label'=>'Kategori',
			'rules'=>array(
				'required'=>'Lütfen Kategori seçiniz'
			),
			'related'=>'Kategori'
		),
		'sira'=>array(
			'type'=>'integer',
			'label'=>'Sıra',
			'rules'=>array(),
		),
		'logo'=>array(
			'type'=>'image',
			'label'=>'Logo',
			'rules'=>array(),
		),
		
		'baslik_tr'=>array(
			'type'=>'text',
			'label'=>'Başlık (TR)',
			'rules'=>array(
				//'required'=>'Lütfen Başlık (TR) giriniz'
			),
			//'unique'=>true,
			'tabgroup'=>'Başlık',
			'tablabel'=>'TR',
		),
		'baslik_az'=>array(
			'type'=>'text',
			'label'=>'Başlık (AZ)',
			'rules'=>array(
				//'required'=>'Lütfen Başlık (AZ) giriniz'
			),
			//'unique'=>true,
			'tabgroup'=>'Başlık',
			'tablabel'=>'AZ',
		),
		'baslik_en'=>array(
			'type'=>'text',
			'label'=>'Başlık (EN)',
			'rules'=>array(
				//'required'=>'Lütfen Başlık (EN) giriniz'
			),
			//'unique'=>true,
			'tabgroup'=>'Başlık',
			'tablabel'=>'EN',
		),
		'baslik_ru'=>array(
			'type'=>'text',
			'label'=>'Başlık (RU)',
			'rules'=>array(
				//'required'=>'Lütfen Başlık (RU) giriniz'
			),
			//'unique'=>true,
			'tabgroup'=>'Başlık',
			'tablabel'=>'RU',
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
		
		'videolar'=>array(
			'type'=>'text',
			'label'=>'Video',
			'rules'=>array(),
		),
		'mektup'=>array(
			'type'=>'file',
			'label'=>'Mektup',
			'rules'=>array(),
		),

	);
}
