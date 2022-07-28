<?php

class CSeoHelper extends CHelper {
	
	public static function applyModelSeo(& $model,$description_key='seo_description',$keywords_key='seo_keywords'){
		$seo_description = $model->{$description_key};
		if(!empty($seo_description)){
			_setAppData( 'seo_description', $seo_description);
		}
		$keywords = $model->{$keywords_key};
		if(!empty($keywords)){
			_setAppData( 'seo_keywords', $keywords );
		}
	}
}