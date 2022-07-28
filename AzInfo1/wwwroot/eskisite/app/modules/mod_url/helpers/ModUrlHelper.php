<?php

class ModUrlHelper extends CHelper
{
	public static function headerTags($defaults = array('title'=>'','desc'=>'','keywords'=>''))
	{		
		$web_url = CUrlHelper::getWebUrl(true);
		
		$locales = array(
			'tr'=>'tr_TR',
			'en'=>'en_US',
			'ru'=>'ru_RU',
		);
		
		
		$lang_urls = array(
			'tr'=> _getAppData('lang_url_tr'),
			'en'=> _getAppData('lang_url_en'),    
			'ru'=> _getAppData('lang_url_ru'),
		);
		
		$page_url = $lang_urls[LANG];
		$canonical_url = $web_url . $page_url;
						
		$url_list = self::get_url_list();
		if(isset($url_list[$page_url])){ // url tanımlarda var bilgilerini al
			$url_data = $url_list[$page_url];
		} else { // url listede yok eklenmesi için gönder
			ModUrlHelper::addUrl($page_url);
		}
		
		if(isset($url_data)){
			$_redirect = !empty($url_data['yonlendir'])?$url_data['yonlendir']:'';
			
			if(!empty($_redirect)){
				CUrlHelper::redirectUrl($_redirect);
			}
			
			$_title = !empty($url_data['baslik'])?$url_data['baslik']:$defaults['title'];
			$_desc = !empty($url_data['aciklama'])?$url_data['aciklama']:$defaults['desc'];
			$_keywords = !empty($url_data['kelimeler'])?$url_data['kelimeler']:$defaults['keywords'];
			$_locale = isset($locales[$url_data['dil']])?$locales[$url_data['dil']]:'';
			$_type = !empty($url_data['tur'])?$url_data['tur']:'';
			$_image = CImageHelper::get($url_data['resim']);
			if(!empty($_image)){
				$_image = $web_url . $_image;
			}
			$_tags = self::lines($url_data['tags']);
			
			_setAppData('seo_description', $_desc);			
			_setAppData('seo_keywords', $_keywords);
			?>


			<?php if(!empty($_locale)){ ?><meta property="og:locale" content="<?=$_locale?>" /><?php } ?>
			<?php if(!empty($_type)){ ?><meta property="og:type" content="<?=$_type?>" /><?php } ?>
			<meta property="og:title" content="<?=$_title?>" />
			<meta property="og:description" content="<?=$_desc?>" />
			<meta property="og:url" content="<?=$canonical_url?>" />
			<meta property="og:site_name" content="Info Group" />
			<?php /*<meta property="article:publisher" content="https://www.facebook.com/taximpro" />*/ ?>
			<?php /* <meta property="article:author" content="https://www.facebook.com/taximpro" />*/ ?>
			<?php foreach($_tags as $_t){
				if(empty($_t)){ continue; }
				?>
			<meta property="article:tag" content="<?=$_t?>" />
			<?php } ?>    
			<meta property="article:section" content="<?=$_title?>" />
			<?php if(!empty($url_data['ts'])){ ?><meta property="article:published_time" content="<?= date('c',$url_data['ts'])?>" /><?php } ?>
			<?php if(!empty($url_data['tarih_duzenleme'])){ 
				$ts2 = strtotime($url_data['tarih_duzenleme']); 
				?>
			<meta property="article:modified_time" content="<?= date('c',$ts2) ?>" />
			<meta property="og:updated_time" content="<?= date('c',$ts2) ?>" />
			<?php } ?>			
			<?php if(!empty($_image)){ ?><meta property="og:image" content="<?=$_image?>" /><?php } ?>
			<?php /* <meta property="og:image:width" content="900" />
			<meta property="og:image:height" content="600" /> */ ?>

			<meta name="twitter:card" content="<?=$_desc?>" />
			<meta name="twitter:description" content="<?=$_desc?>" />
			<meta name="twitter:title" content="<?=$_title?>" />
			<?php /* <meta name="twitter:site" content="@taximpro " />*/?>
			<?php if(!empty($_image)){ ?><meta name="twitter:image" content="<?=$_image?>" /><?php } ?>
			<?php /* <meta name="twitter:creator" content="@taximpro" /> */?>
			
			<?php
		}
	}
	
	
	public static function get_url_list()
	{
		$cache_id = 'mod_url_list';
		
		$list = array();
		if(($d=  CCacheHelper::get($cache_id, 10))){
			$list =  unserialize($d);
		} else {
			$model = new Mod_url_urlModel();
			$model->run();
			while($model->fetchRow()) {				
				$list[$model->url] = $model->getAsArray();
			}
			unset($model);
			CCacheHelper::store($cache_id,  serialize($list));
		}
		return $list;
	}
	
	public static function addUrl($url)
	{
		$added = false;
		if(_getAppData('module_dir')!='mod_admin')
		{
			if(empty($url)){
				return false;
			}
			$model = new Mod_url_urlModel();
			
			if($model->where('`url` = \''.$url.'\'')->find())
				;
			elseif($model->insert(array(
					'url'=>$url,
					'ts'=>time(),
					'dil'=>LANG					
				))
			){
				$added = true;
			}
		}
		return $added;
	}
	
	// Textarea içeriğini tekil liste yada sütunlu birden fazla liste olarak döner
	public static function lines($str,$cols=1){
		$lines = explode(PHP_EOL,$str);
		if($cols==1){
			return $lines;
		}
		else {
			$size = ceil(count($lines)/$cols);
			$groups = array_chunk($lines, $size);
			$n = count($groups);
			$diff = $cols-$n;
			for($i=0;$i<$diff;$i++){
				$groups[] = array();
			}
			return $groups;
		}
	}
}
