<?php

class IkForm extends CForm
{
	public $_fields = array(
		
		//'test'=>array('rules'=>array('required'=>'(Test field validation)')),
		
		'ip'=>array(
			'type'=>'hidden',
			'label'=>'IP'
		),
		'isim'=>array(
			'label'=>'Ad Soyad',
			'type'=>'text',
			'rules'=>array(
				'required'=>'Lütfen Ad Soyad giriniz'
			)
		),
		'email'=>array(
			'label'=>'E-mail',
			'type'=>'text',
			'rules'=>array(
				'required'=>'E-posta alanı gereklidir',
				'email'=>'Lütfen geçerli bir e-posta adresi giriniz'
			)
		),
		'telefon'=>array(
			'label'=>'Telefon',
			'type'=>'text',
			'rules'=>array(
				'required'=>'Lütfen Telefon giriniz'
			)
		),
		'mesaj'=>array(
			'label'=>'Mesaj',
			'type'=>'textarea',
			'rules'=>array()
		),
		/*'kepce'=>array(
			'label'=>'Güvenlik kodu',
			'type'=>'text',
			'rules'=>array(
				'required'=>'Lütfen Güvenlik kodu giriniz',
				'captcha'=>'Güvenlik kodu hatalı!'
			)
		),*/
		
	);	
		
	public function validate()
	{
		$this->ip = CCoreHelper::getUserIp();
		return $this->_validated;
	}		
}
