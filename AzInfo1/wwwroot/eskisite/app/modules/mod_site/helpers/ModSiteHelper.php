<?php

class ModSiteHelper extends CHelper {
	
	public static $ayarlar = null;
	
	public static function get_ayar($key){
		if(!is_array(self::$ayarlar)){
			$model = new Mod_site_ayarModel();
			if($model->find()) {
				$ayarlar = array();
				foreach($model->_data as $name=>$value) {
					$ayarlar[$name] = $value;
				}
				self::$ayarlar = $ayarlar;
			}else throw new Exception('HATA..');
		}		
		return isset(self::$ayarlar[$key]) ? self::$ayarlar[$key] : null ;
	}
	
	public static function get_emails($colName){
		$alici_email = array();
		$form_alicilar = explode(',',self::get_ayar($colName));
		foreach($form_alicilar as $to){
			$to = trim($to);
			if(!empty($to)){
				$alici_email [] = $to;
			}
		}		
		$alici_email = array_unique($alici_email);
		return $alici_email;
	}
	
}