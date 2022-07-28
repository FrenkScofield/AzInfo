<?php

$admin_key = 'admin';

$_config['main'] = array(
	// Url settings
	'urlType' => 'canonical'.(IS_LOCALHOST?'':'2'), // [ parametric , canonical, canonical2 ( for RewriteRule ^(.*)$ index.php?/$1 [L] in .htaccess) ]
	'requestParameter' => 'a', // ?a=controller/method (only for parametric urls)
	'useScriptName' => IS_LOCALHOST, // begin urls with script name ( needed for canonical urls if htaccess rewrite rule not defined )
	'urlExtension' => '', // may be used to add extension to urls (best use: urlType=canonical , )
	'languageRouting' => true,
	'languages' => array('tr','az','en','ru'),
	'defaultLanguage' => 'az',
	'defaultController' => 'Main',
	'defaultTitle' => 'INFO GROUP',
	'rootTitle' => 'INFO GROUP',
	'titleSeparator' => ' - ',
	'reverseTitle' => true,
	
	'routes' => array(
		'' => 'main/index',
		'arama' => 'arama/main',
		'kurumsal' => 'main/kurumsal',
		'hizmetler' => 'main/hizmetler',
		
		'belgeler' => 'main/belgeler', // ürünler menüsü
		
		'teknik_belgeler' => 'main/teknik_belgeler', // sertifikalar menüsü
		'kalite_belgeleri' => 'main/kalite_belgeleri', // sertifikalar menüsü
		'sistem_bilgi_formatlari' => 'main/sistem_bilgi_formatlari', // sertifikalar menüsü
		
		'referanslar' => 'main/referanslar',
		'haberler' => 'main/haberler',
		'iletisim' => 'main/iletisim',
		'seminerler' => 'main/seminerler',
		'insan_kaynaklari' => 'main/insan_kaynaklari',
		
		'urunlerimiz' => 'main/urunler',
		'urunlerimiz/(:any)'=>'main/urunler/cid/$1',
		
		'nsfli_urunlerimiz' => 'main/nsf_urunler',
		'ozon_sistemleri' => 'main/ozon_sistemleri',
		'ozon_sistemleri/(:any)' => 'main/ozon_sistemleri/id/$1',
		
	),
	
	'mod_admin_menu' => array(
		'Anasayfa'=>array(
			'Banner'=>array('action'=>'admin_banner/list'),			
			'Mobil slider'=>array('action'=>'admin_banner_mobil/list'),
			'Video'=>array('action'=>'admin_video/list'),
			'Hizmetler'=>array('action'=>'admin_anasayfa_hizmet/list'),
			'Referanslar'=>array('action'=>'admin_anasayfa_referans/list'),
			'Logolar'=>array('action'=>'admin_anasayfa_logo/list'),
		),
		'Kurumsal'=>array('action'=>'admin_kurumsal/editOne'),
		'İK'=>array('action'=>'admin_ik/editOne'),
		'Seminerler'=>array(
			'İçerik'=>array('action'=>'admin_seminerler/editOne'),
			'Seminerler'=>array('action'=>'admin_seminer/list'),
		),
		
		'Hizmetler'=>array('action'=>'admin_hizmet/list'),
		'Ürünler'=>array(
			'Ürünlerimiz'=>array(
				'Kategoriler'=>array('action'=>'admin_urun_kategori/list'),
				'Ürünler'=>array('action'=>'admin_urun/list'),
			),
			'NSF\'li Ürünlerimiz'=>array('action'=>'admin_nsf/list'),
			'Ozon Sistemleri'=>array('action'=>'admin_ozon/list'),
			'Belgeler'=>array('action'=>'admin_belgeler/list'),
		),
		'Sertifikalar'=>array(
			'Teknik Belgeler'=>array('action'=>'admin_teknik_belgeler/list'),
			'Kalite Belgeleri'=>array('action'=>'admin_kalite_belgeleri/list'),
			'Sistem Bilgi Formatları'=>array('action'=>'admin_sistem_bilgi_formatlari/list'),
		),
		'Referanslar'=>array(
			'Kategoriler'=>array('action'=>'admin_referans_kategori/list'),
			'Referanslar'=>array('action'=>'admin_referans/list'),
		),
		'Haberler'=>array('action'=>'admin_haber/list'),
		'İletişim'=>array('action'=>'admin_iletisim_adres/list'),
		'Bölüm Ayarları'=>array('action'=>'admin_bolum_ayar/list'),
		'Popup'=>array('action'=>'admin_mod_popup_popup/list'),
	),
	
	'modules' => array(
		'_url' => array('module' => 'mod_url'),
		'arama' => array('module' => 'mod_search'),
		'_popup' => array('module' => 'mod_popup'),
		'_lang' => array('module' => 'mod_lang'),
		'_site' => array('module' => 'mod_site'),
		
		$admin_key => array('module' => 'mod_admin', 'params' => array(
			'login_captcha' => false,
			//'allow_demo_mode'=>true,
		)),
	),
	
	'image_size_options' => array(
		'hizmet'=>array('prefix'=>'hizmet_', 'x'=>130,'y'=>105,'ratio'=>true,'ratio_crop'=>true),
        'belge'=>array('prefix'=>'belge_', 'x'=>230,'y'=>300,'ratio'=>true,'ratio_crop'=>true),
		'nsf'=>array('prefix'=>'nsf_', 'x'=>230,'y'=>135,'ratio'=>true,'ratio_crop'=>true),
	)
);




// Following functions may be used for custom modification of admin menu tree and menu config arrays (moving menu elements etc.)
/*
function _admin_menu_tree_modify($menu_tree){
	//debug($menu_tree);
	$_config = _getAppData('config');
	// modify menu tree
	// ...
	return $menu_tree;
}

function _admin_menu_config_modify($menu_config){
	//debug($menu_config);
	$_config = _getAppData('config');
	// modify menu config
	// ...
	return $menu_config;
}
*/
