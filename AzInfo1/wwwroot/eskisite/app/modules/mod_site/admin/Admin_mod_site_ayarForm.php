<?php

class Admin_mod_site_ayarForm extends CForm
{
	public $_fields = array(
		'id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		
		'metin1_tr'=>array(
			'type'=>'textarea',
			'label'=>'Metin 1 (TR)',
			'rules'=>array(),
			'tabgroup'=>'Anasayfa',
			'tablabel'=>'Metin 1',
		),
		'metin1_az'=>array(
			'type'=>'textarea',
			'label'=>'Metin 1 (AZ)',
			'rules'=>array(),
			'tabgroup'=>'Anasayfa',
			'tablabel'=>'Metin 1',
		),
		'metin1_en'=>array(
			'type'=>'textarea',
			'label'=>'Metin 1 (EN)',
			'rules'=>array(),
			'tabgroup'=>'Anasayfa',
			'tablabel'=>'Metin 1',
		),
		'metin1_ru'=>array(
			'type'=>'textarea',
			'label'=>'Metin 1 (RU)',
			'rules'=>array(),
			'tabgroup'=>'Anasayfa',
			'tablabel'=>'Metin 1',
		),
		
		'metin2_tr'=>array(
			'type'=>'textarea',
			'label'=>'Metin 2 (TR)',
			'rules'=>array(),
			'tabgroup'=>'Anasayfa',
			'tablabel'=>'Metin 2',
		),
		'metin2_az'=>array(
			'type'=>'textarea',
			'label'=>'Metin 2 (AZ)',
			'rules'=>array(),
			'tabgroup'=>'Anasayfa',
			'tablabel'=>'Metin 2',
		),
		'metin2_en'=>array(
			'type'=>'textarea',
			'label'=>'Metin 2 (EN)',
			'rules'=>array(),
			'tabgroup'=>'Anasayfa',
			'tablabel'=>'Metin 2',
		),
		'metin2_ru'=>array(
			'type'=>'textarea',
			'label'=>'Metin 2 (RU)',
			'rules'=>array(),
			'tabgroup'=>'Anasayfa',
			'tablabel'=>'Metin 2',
		),
		
		
		
		/*'baslik_tr'=>array(
			'type'=>'text',
			'label'=>'Başlık (TR)',			
			'rules'=>array(
				'required'=>'Başlık (TR) gereklidir'
			),
		),
		'baslik_en'=>array(
			'type'=>'text',
			'label'=>'Başlık (EN)',			
			'rules'=>array(
				'required'=>'Başlık (EN) gereklidir'
			),
		),
		'baslik_ru'=>array(
			'type'=>'text',
			'label'=>'Başlık (RU)',			
			'rules'=>array(
				'required'=>'Başlık (RU) gereklidir'
			),
		),*/
		/*'aciklama_tr'=>array(
			'type'=>'text',
			'counter'=>true,
			'label'=>'Açıklama (TR)',
			'rules'=>array(),
		),
		'aciklama_en'=>array(
			'type'=>'text',
			'counter'=>true,
			'label'=>'Açıklama (EN)',
			'rules'=>array(),
		),
		'aciklama_ru'=>array(
			'type'=>'text',
			'counter'=>true,
			'label'=>'Açıklama (RU)',
			'rules'=>array(),
		),
		'kelimeler_tr'=>array(
			'type'=>'text',
			'counter'=>true,
			'label'=>'Kelimeler (TR)',
			'info'=>'Virgülle ayırarak yazınız',
			'rules'=>array(),
		),
		'kelimeler_en'=>array(
			'type'=>'text',
			'counter'=>true,
			'label'=>'Kelimeler (EN)',
			'info'=>'Virgülle ayırarak yazınız',
			'rules'=>array(),
		),
		'kelimeler_ru'=>array(
			'type'=>'text',
			'counter'=>true,
			'label'=>'Kelimeler (RU)',
			'info'=>'Virgülle ayırarak yazınız',
			'rules'=>array(),
		),*/
		'mail_host'=>array(
			'type'=>'text',
			'label'=>'Email sunucusu',
			'info'=>'Boş değilse SMTP kullanılır (ör: mail.domain.com)',
			'rules'=>array(),
			'tabgroup'=>'Ayarlar',
			'tablabel'=>'E-mail',
		),
		'mail_port'=>array(
			'type'=>'text',
			'label'=>'Email Port',
			'info'=>'(Varsayılan: 587)',
			'rules'=>array(),
			'tabgroup'=>'Ayarlar',
			'tablabel'=>'E-mail',
		),
		'mail_username'=>array(
			'type'=>'text',
			'label'=>'Email kullanıcı',
			'rules'=>array(),
			'tabgroup'=>'Ayarlar',
			'tablabel'=>'E-mail',
		),
		'mail_password'=>array(
			'type'=>'text',
			'label'=>'Email parola',
			'rules'=>array(),
			'tabgroup'=>'Ayarlar',
			'tablabel'=>'E-mail',
		),
		/*'form1_alicilar'=>array(
			'type'=>'text',
			'label'=>'İletişim formu alıcıları',
			'info'=>'Birden fazla adresi virgülle ayırarak yazınız',
			'rules'=>array(),
		),*/
		'form2_alicilar'=>array(
			'type'=>'text',
			'label'=>'İK formu alıcıları',
			'info'=>'Birden fazla adresi virgülle ayırarak yazınız',
			'rules'=>array(),
			'tabgroup'=>'Ayarlar',
			'tablabel'=>'E-mail',
		),
		/*'form3_alicilar'=>array(
			'type'=>'text',
			'label'=>'Öneri/Şikayet formu alıcıları',
			'info'=>'Birden fazla adresi virgülle ayırarak yazınız',
			'rules'=>array(),
		),
		'form4_alicilar'=>array(
			'type'=>'text',
			'label'=>'Memnuniyet Anketi formu alıcıları',
			'info'=>'Birden fazla adresi virgülle ayırarak yazınız',
			'rules'=>array(),
		),
		*/
		
		'sosyal_url1'=>array(
			'type'=>'text',
			'label'=>'Email adresi',
			'rules'=>array(),
			'tabgroup'=>'Ayarlar',
			'tablabel'=>'Sosyal medya',
		),
		'sosyal_url2'=>array(
			'type'=>'text',
			'label'=>'Facebook url',
			'rules'=>array(),
			'tabgroup'=>'Ayarlar',
			'tablabel'=>'Sosyal medya',
		),
		'sosyal_url3'=>array(
			'type'=>'text',
			'label'=>'Linkedin url',
			'rules'=>array(),
			'tabgroup'=>'Ayarlar',
			'tablabel'=>'Sosyal medya',
		),
		/*'sosyal_url4'=>array(
			'type'=>'text',
			'label'=>'Google+ url',
			'rules'=>array(),
			'tabgroup'=>'Ayarlar',
			'tablabel'=>'Sosyal medya',
		),*/
		
	);
}
