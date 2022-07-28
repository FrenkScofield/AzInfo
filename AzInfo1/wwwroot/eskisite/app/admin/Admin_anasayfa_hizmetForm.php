<?php

class Admin_anasayfa_hizmetForm extends CForm
{
	public $_fields = array(
		'anasayfa_hizmet_id'=>array(
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
			'rules'=>array(),
			'tabgroup'=>'Başlık',
			'tablabel'=>'TR',
		),
		'baslik_az'=>array(
			'type'=>'text',
			'label'=>'Başlık (AZ)',
			'rules'=>array(),
			'tabgroup'=>'Başlık',
			'tablabel'=>'AZ',
		),
		'baslik_en'=>array(
			'type'=>'text',
			'label'=>'Başlık (EN)',
			'rules'=>array(),
			'tabgroup'=>'Başlık',
			'tablabel'=>'EN',
		),
		'baslik_ru'=>array(
			'type'=>'text',
			'label'=>'Başlık (RU)',
			'rules'=>array(),
			'tabgroup'=>'Başlık',
			'tablabel'=>'RU',
		),
		
		'yazi_tr'=>array(
			'type'=>'textarea',
			'label'=>'Yazı (TR)',
			'rules'=>array(),
			'tabgroup'=>'Yazı',
			'tablabel'=>'TR',
		),
		'yazi_az'=>array(
			'type'=>'textarea',
			'label'=>'Yazı (AZ)',
			'rules'=>array(),
			'tabgroup'=>'Yazı',
			'tablabel'=>'AZ',
		),
		'yazi_en'=>array(
			'type'=>'textarea',
			'label'=>'Yazı (EN)',
			'rules'=>array(),
			'tabgroup'=>'Yazı',
			'tablabel'=>'EN',
		),
		'yazi_ru'=>array(
			'type'=>'textarea',
			'label'=>'Yazı (RU)',
			'rules'=>array(),
			'tabgroup'=>'Yazı',
			'tablabel'=>'RU',
		),
		
		'resim'=>array(
			'type'=>'image',
			'label'=>'Resim',
			'rules'=>array(),
		),

	);
}
