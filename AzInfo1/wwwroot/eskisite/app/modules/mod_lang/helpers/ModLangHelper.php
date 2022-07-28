<?php
/**
 * addWord işlevi tercüme tablosunda bulunduğu halde karşılık girilmemiş olan tüm satırlar için SELECT sorgusu çalışmasına neden oluyordu.
 * Gereksiz sorgulardan kurtulmak için tercümeleri karşılığı girilmemiş olanları da dahil ederek aldım.
 * (_lang ve _mlang işlevleri zaten karşılık yoksa anahtar değerini döndürüyor)
 */

class ModLangHelper extends CHelper
{
	public static function get_i18n_array($lang=null)
	{
		if($lang==null)
		{
			$lang = _getAppData('lang');
		}
		$cache_id = 'mod_lang_i18n_'.$lang;
		
		// tercüme listesinin tamamını (boş olanlar da dahil olarak) al  ve önbelleğe kaydet
		$dict = array();
		if(($d=  CCacheHelper::get($cache_id, 10))){
			$dict =  unserialize($d);
		} else {
			$model = new ModLangDictModel();
			$model->run();
			while($model->fetchRow()) {
				$dict[$model->key] = $model->$lang;
			}
			unset($model);
			CCacheHelper::store($cache_id,  serialize($dict));
		}
		return $dict;
	}
	
	public static function addWord($key)
	{
		$added = false;
		if(_getAppData('module_dir')!='mod_admin')
		{
			$model = new ModLangDictModel();
			$key = $model->real_escape_string($key);
			if(empty($key)){
				return false;
			}
			
			if($model->where('`key` COLLATE utf8_bin = \''.$key.'\'')->find())
				;
			elseif($model->insert(array('key'=>$key)))
			{
				$added = true;
			}
		}
		return $added;
	}
}
