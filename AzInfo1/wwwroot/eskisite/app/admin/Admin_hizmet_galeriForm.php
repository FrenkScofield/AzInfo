<?php

class Admin_hizmet_galeriForm extends CForm
{
	public $_fields = array(
		'hizmet_galeri_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		'hizmet_id'=>array(
			'type'=>'autocomplete',
			'label'=>'Hizmet',
			'rules'=>array(
				'required'=>'Lütfen Hizmet seçiniz'
			),
			'related'=>'Hizmet',			
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
		'link'=>array(
			'type'=>'text',
			'label'=>'Link',
			'info'=>'(youtube vs.)',
			'rules'=>array(),
		),

	);
}
