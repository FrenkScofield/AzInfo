<?php 

$_lang['main'] = array(
		
);

require_once APP_PATH.'/modules/mod_lang/helpers/ModLangHelper.php';
require_once APP_PATH.'/modules/mod_lang/models/ModLangDictModel.php';

$map = ModLangHelper::get_i18n_array();

$_lang['main'] = array_merge($_lang['main'],$map);
