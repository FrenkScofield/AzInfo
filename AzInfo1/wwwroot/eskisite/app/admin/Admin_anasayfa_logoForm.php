<?php

class Admin_anasayfa_logoForm extends CForm
{
	public $_fields = array(
		'anasayfa_logo_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		'sira'=>array(
			'type'=>'integer',
			'label'=>'Sıra',
			'rules'=>array(),
		),
		'resim'=>array(
			'type'=>'image',
			'label'=>'Resim',
			'rules'=>array(),
		),
		'resim2'=>array(
			'type'=>'image',
			'label'=>'Resim (lightbox)',
			'rules'=>array(),
		),
		'link'=>array(
			'type'=>'text',
			'label'=>'Link',
			'rules'=>array(),
		),

	);
}
