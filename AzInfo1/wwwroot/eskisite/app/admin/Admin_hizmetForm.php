<?php

class Admin_hizmetForm extends CForm
{
	public $_fields = array(
		'hizmet_id'=>array(
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
		
		'footer_goster'=>array(
			'type'=>'checkbox',
			'label'=>'Footerda listele',
			'rules'=>array()
		),
		
		'aciklama_tr'=>array(
			'type'=>'textarea',
			'label'=>'Açıklama (TR)',
			'rules'=>array(),
		),
		'aciklama_az'=>array(
			'type'=>'textarea',
			'label'=>'Açıklama (AZ)',
			'rules'=>array(),
		),
		'aciklama_en'=>array(
			'type'=>'textarea',
			'label'=>'Açıklama (EN)',
			'rules'=>array(),
		),
		'aciklama_ru'=>array(
			'type'=>'textarea',
			'label'=>'Açıklama (RU)',
			'rules'=>array(),
		),
		'resim'=>array(
			'type'=>'image',
			'label'=>'Resim',
			'rules'=>array(),
		),
		/*'resimler'=>array(
			'type'=>'images',
			'label'=>'Galeri',
			'rules'=>array(),
		),*/

	);
}
