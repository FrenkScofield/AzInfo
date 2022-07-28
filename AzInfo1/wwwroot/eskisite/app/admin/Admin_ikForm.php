<?php

class Admin_ikForm extends CForm
{
	public $_fields = array(
		'ik_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),			
		),
		'yazi_tr'=>array(
			'type'=>'cke',
			'label'=>'Yazı (TR)',
			'rules'=>array(),
			'tabgroup'=>'Yazı',
			'tablabel'=>'TR',
		),
		'yazi_az'=>array(
			'type'=>'cke',
			'label'=>'Yazı (AZ)',
			'rules'=>array(),
			'tabgroup'=>'Yazı',
			'tablabel'=>'AZ',
		),
		'yazi_en'=>array(
			'type'=>'cke',
			'label'=>'Yazı (EN)',
			'rules'=>array(),
			'tabgroup'=>'Yazı',
			'tablabel'=>'EN',
		),
		'yazi_ru'=>array(
			'type'=>'cke',
			'label'=>'Yazı (RU)',
			'rules'=>array(),
			'tabgroup'=>'Yazı',
			'tablabel'=>'RU',
		),

	);
}
