<?php

class Admin_banner_mobilForm extends CForm
{
	public $_fields = array(
		'banner_id'=>array(
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

	);
}
