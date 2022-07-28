<?php

class Admin_bolum_ayarForm extends CForm
{
	public $_fields = array(
		'bolum_id'=>array(
			'type'=>'hidden',
			'label'=>'Id',
			'rules'=>array(),
		),
		'bolum'=>array(
			'type'=>'select',
			'label'=>'Bölüm',
			'rules'=>array(
				'required'=>'Lütfen Bölüm seçiniz'
			),
			'unique'=>true,
			'options'=>array(
				'kurumsal'=>'Kurumsal',
				'hizmetler'=>'Hizmetler',
				'urunler'=>'Ürünlerimiz',
				'nsf_urunler'=>'NSFli Ürünlerimiz',
				'ozon_sistemleri'=>'Ozon Sistemleri',				
				'belgeler'=>'Belgeler',
				'teknik_belgeler'=>'Teknik Belgeler',
				'kalite_belgeleri'=>'Kalite Belgeleri',
				'sistem_bilgi_formatlari'=>'Sistem Bilgi Formatları',
				'referanslar'=>'Referanslar',
				'haberler'=>'Haberler',
				'iletisim'=>'İletişim',
				'ik'=>'İnsan Kaynakları',
				'seminerler'=>'Seminerler',
			)
		),
		'ustbanner'=>array(
			'type'=>'image',
			'label'=>'Üst banner',
			'rules'=>array(),
		),

	);
}
