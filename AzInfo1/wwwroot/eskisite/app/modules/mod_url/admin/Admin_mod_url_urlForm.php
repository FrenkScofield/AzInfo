<?php

class Admin_mod_url_urlForm extends CForm
{
	public $_fields = array(
		'url_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		'url'=>array(
			'type'=>'text',
			'label'=>'Url',
			'rules'=>array(),
			'editable'=>FALSE,
		),
		'dil'=>array(
			'type'=>'lang',
			'label'=>'Dil',
			'rules'=>array(
				//'required'=>'Lütfen Dil seçiniz'
			),
			'editable'=>FALSE,
		),
		'ts'=>array(
			'type'=>'timestamp',
			'label'=>'Oluşma zamanı',
			'rules'=>array(),
			'editable'=>FALSE,
		),
		'tarih_duzenleme'=>array(
			'type'=>'date',
			'label'=>'Düzenleme tarihi',
			'rules'=>array(),
		),
		'tur'=>array(
			'type'=>'select',
			'label'=>'Tür',
			'rules'=>array(
				//'required'=>'Lütfen Tür seçiniz'
			),
			'options'=>array(
				'article'=>'Makale'
			),
		),
		'baslik'=>array(
			'type'=>'text',
			'label'=>'Başlık',
			'rules'=>array(),
			'counter'=>true
		),
		'yonlendir'=>array(
			'type'=>'text',
			'label'=>'Yönlendir',
			'rules'=>array()			
		),
		'resim'=>array(
			'type'=>'image',
			'label'=>'Resim',
			'rules'=>array()			
		),
		'aciklama'=>array(
			'type'=>'text',
			'label'=>'Açıklama',
			'rules'=>array(),
			'counter'=>true
		),
		'kelimeler'=>array(
			'type'=>'text',
			'label'=>'Kelimeler',
			'rules'=>array(),
			'counter'=>true
		),
		'tags'=>array(
			'type'=>'textarea',
			'label'=>'Etiketler',
			'rules'=>array(),
		),

	);
}
