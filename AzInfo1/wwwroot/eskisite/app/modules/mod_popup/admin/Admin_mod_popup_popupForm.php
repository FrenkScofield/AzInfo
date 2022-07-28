<?php

class Admin_mod_popup_popupForm extends CForm
{
	public $_fields = array(
		'popup_id'=>array(
			'label'=>'Id',
			'type'=>'hidden'
		),		
		'aktif'=>array(
			'label'=>'Aktif',
			'type'=>'checkbox'
		),
		'sira'=>array(
			'label'=>'Sıra',
			'type'=>'integer',
			'value'=>'999',
		),
		'dil'=>array(			
			'label'=>'Dil',
			'type'=>'lang',
			'rules'=>array(				
				'required'=>'Dil seçimi gereklidir'
			),
			'options'=>array()
		),
		/*'baslik'=>array(
			'label'=>'Başlık',
			'type'=>'text',			
		),*/
		'resim'=>array(
			'label'=>'Resim',
			'type'=>'image',			
			'size_options'=>array(),
		),
		/*'link'=>array(
			'label'=>'Link',
			'type'=>'text',
		),*/
		'bas_tarih'=>array(
			'label'=>'Başlangıç tarihi',
			'type'=>'date',
		),
		'bit_tarih'=>array(
			'label'=>'Bitiş tarihi',
			'type'=>'date',
		),
	);
}
