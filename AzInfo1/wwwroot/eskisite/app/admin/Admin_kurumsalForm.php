<?php

class Admin_kurumsalForm extends CForm
{
	public $_fields = array(
		'kurumsal_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		'baslik_tr'=>array(
			'type'=>'text',
			'label'=>'Başlık (TR)',
			'rules'=>array(),
		),
		'baslik_az'=>array(
			'type'=>'text',
			'label'=>'Başlık (AZ)',
			'rules'=>array(),
		),
		'baslik_en'=>array(
			'type'=>'text',
			'label'=>'Başlık (EN)',
			'rules'=>array(),
		),
		'baslik_ru'=>array(
			'type'=>'text',
			'label'=>'Başlık (RU)',
			'rules'=>array(),
		),
		'resim'=>array(
			'type'=>'image',
			'label'=>'Resim',
			'rules'=>array(),
		),
		'yazi_tr'=>array(
			'type'=>'cke',
			'label'=>'Yazı (TR)',
			'rules'=>array(),
		),
		'yazi_az'=>array(
			'type'=>'cke',
			'label'=>'Yazı (AZ)',
			'rules'=>array(),
		),
		'yazi_en'=>array(
			'type'=>'cke',
			'label'=>'Yazı (EN)',
			'rules'=>array(),
		),
		'yazi_ru'=>array(
			'type'=>'cke',
			'label'=>'Yazı (RU)',
			'rules'=>array(),
		),

	);
}
