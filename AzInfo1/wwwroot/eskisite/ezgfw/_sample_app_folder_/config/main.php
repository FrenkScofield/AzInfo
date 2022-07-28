<?php

$admin_key = 'admin';

$_config['main'] = array(
	// Url settings
	'urlType'=>'canonical', // [ parametric , canonical, canonical2 ( for RewriteRule ^(.*)$ index.php?/$1 [L] in .htaccess) ]
	'requestParameter'=>'a', // ?a=controller/method (only for parametric urls)
	'useScriptName'=>IS_LOCALHOST, // begin urls with script name ( needed for canonical urls if htaccess rewrite rule not defined )
	'urlExtension'=>'', // may be used to add extension to urls (best use: urlType=canonical , )
	
	'languageRouting'=>false,		
	'languages'=>array('tr'),
	'defaultLanguage'=>'tr',
	
	'defaultController'=>'Main',
	
	'defaultTitle'=>'Default Title',
	'rootTitle'=>'Root Title',
	'titleSeparator'=>' - ',
	'reverseTitle'=>true,
	
	'routes'=>array(
		''=>'main/index',
		//'page/(:any)'=>'main/page/id/$1',
	),
		
	'mod_admin_menu'=>array(
		// 'Menu Item Title'=>array('action'=>'admin_content/list'),
	),
	
	// yönetim paneli menü simge ayarları (simge isimleri için: http://fontawesome.io/icons/)
	'mod_admin_menu_icon_map'=>array(
		//'Kategoriler'=>'sitemap',
	),
		
	'modules'=>array(
		
		//'mod'=>array('module'=>'mod_'),
		
		$admin_key=>array('module'=>'mod_admin','params'=>array(
			'login_captcha'=>false,
			//'allow_demo_mode'=>true,
		)),
		
	),
		
	'image_size_options'=>array(
		//'k'=>array('prefix'=>'k_', 'x'=>80,'y'=>80,'ratio'=>true,'ratio_crop'=>true),
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
