<?php 
$_lang['main'] = array(
	 '404 - Page not found!'=>'404 - Sayfa bulunamadı!',
	 'Database connection failed!'=>'Veritabanı bağlantısı başarısız!',
);

if(is_file(APP_PATH.'/modules/mod_lang/helpers/ModLangHelper.php')){
	$map = ModLangHelper::get_i18n_array();
	$_lang['main'] = array_merge($_lang['main'],$map);
	
	if(!function_exists('_l_fail_callback')){
		function _l_fail_callback($key){
			ModLangHelper::addWord($key);
		}
	}
}
