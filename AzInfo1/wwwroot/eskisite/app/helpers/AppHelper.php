<?php

class AppHelper {
	
	
	public static function bolum_ayarlari($bolum) {
		// önce ayarları al (varsa önbellekten), daha sonra istenen bölümle ilgili ayarları tanımla		
		$cache_id = 'bolumayarlari_' . LANG;
		if (($d = CCacheHelper::get($cache_id, 10))) {
			$bolumler = unserialize($d);
		} else {
			$bolumler = array();
			$model = new Bolum_ayarModel();
			$model->run();
			while ($model->fetchRow()) {
				$bolumler[$model->bolum] = array(
					'ustbanner' => CImageHelper::get($model->ustbanner)
				);
			}
			CCacheHelper::store($cache_id, serialize($bolumler));
		}

		if (isset($bolumler[$bolum])) {
			if (!empty($bolumler[$bolum]['ustbanner'])) {
				_setAppData('ustbanner', $bolumler[$bolum]['ustbanner']);
			}
		}
	}
	
	
	public static function getAnasayfa_logolar(){
		$cache_id = 'anasayfalogolar_'.LANG;
		if(($d= CCacheHelper::get($cache_id,10))){
			return unserialize($d);
		}
		
		$return = array();
		
		$model = new Anasayfa_logoModel();
		$model->orderBy('`sira` ASC')->run();
		while($model->fetchRow()){
			$r = CImageHelper::get($model->resim);
			if(empty($r)){
				continue;
			}
			$return[] = array(
				'resim'=>$r,
				'resim2'=>CImageHelper::get($model->resim2), // popup resmi
				'link'=>$model->link
			);
		}
		
		CCacheHelper::store($cache_id, serialize($return));
		return $return;
	}
	
	public static function getAnasayfa_referanslar(){
		$cache_id = 'anasayfarefs_'.LANG;
		if(($d= CCacheHelper::get($cache_id,10))){
			return unserialize($d);
		}
		
		$return = array();
		
		$model = new Anasayfa_referansModel();
		$model->orderBy('`sira` ASC')->run();
		while($model->fetchRow()){
			$r = CImageHelper::get($model->resim);
			if(empty($r)){
				continue;
			}
			$return[] = $r;
		}
		
		CCacheHelper::store($cache_id, serialize($return));
		return $return;
	}
	
	public static function getAnasayfa_video(){
		$cache_id = 'anasayfavideo_'.LANG;
		if(($d= CCacheHelper::get($cache_id,10))){
			return unserialize($d);
		}
		
		$return = array();
		
		$model = new VideoModel();
		$model->where(array('dil'=>LANG))->orderBy('`sira` ASC')->limit(4)->run();
		while($model->fetchRow()){
			$return[] = array(
				'baslik'=>$model->baslik,
				'url'=>$model->url,
				'resim'=> CImageHelper::get($model->resim)
			);
		}
		
		CCacheHelper::store($cache_id, serialize($return));
		return $return;
	}
	
	public static function getAnasayfa_haberler(){
		$cache_id = 'anasayfahaberler_'.LANG;
		if(($d= CCacheHelper::get($cache_id,10))){
			return unserialize($d);
		}
		
		$return = array();
		
		$model = new HaberModel();
		$model->orderBy('`tarih` DESC, `haber_id` DESC')->limit(5)->run();
		while($model->fetchRow()){
			$return[] = array(
				'baslik'=>$model->baslik,
				//'ozet'=>HtmlHelper::kisalt($model->aciklama, 100),
				'resim'=> CImageHelper::get($model->resimler)
			);
		}
		
		CCacheHelper::store($cache_id, serialize($return));
		return $return;
	}
	
	public static function getAnasayfa_hizmet(){
		$cache_id = 'anasayfahizmet_'.LANG;
		if(($d= CCacheHelper::get($cache_id,10))){
			return unserialize($d);
		}
		
		$return = array();
		
		$model = new Anasayfa_hizmetModel();
		$model->orderBy('`sira` ASC')->limit(4)->run();
		while($model->fetchRow()){
			$return[] = array(
				'baslik'=>$model->baslik,
				'yazi'=>$model->yazi,				
				'resim'=> CImageHelper::get($model->resim)
			);
		}
		
		CCacheHelper::store($cache_id, serialize($return));
		return $return;
	}
	
	public static function getBanner(){
		$cache_id = 'banner_'.LANG;
		if(($d= CCacheHelper::get($cache_id,10))){
			return unserialize($d);
		}
		
		$return = array();
		
		$model = new BannerModel();
		$model->where(array('dil'=>LANG))->orderBy('`sira` ASC')->run();
		while($model->fetchRow()){
			$r = CImageHelper::get($model->resim);
			if(empty($r)){
				continue;
			}
			$return[] = $r;
		}
		
		CCacheHelper::store($cache_id, serialize($return));
		return $return;
	}
	
	public static function getBanner_mobil(){
		$cache_id = 'bannermobil_'.LANG;
		if(($d= CCacheHelper::get($cache_id,10))){
			return unserialize($d);
		}
		
		$return = array();
		
		$model = new Banner_mobilModel();
		$model->orderBy('`sira` ASC')->run();
		while($model->fetchRow()){
			$r = CImageHelper::get($model->resim);
			if(empty($r)){
				continue;
			}
			$return[] = $r;
		}
		
		CCacheHelper::store($cache_id, serialize($return));
		return $return;
	}
	
	
	// footerdaki liste için
	public static function getHizmetler(){
		$cache_id = 'hizmetler_'.LANG;
		if(($d= CCacheHelper::get($cache_id,10))){
			return unserialize($d);
		}
		
		$url = CUrlHelper::getUrl('main/hizmetler');
		
		$return = array();
		
		$model = new HizmetModel();
		$model->where(array('footer_goster'=>1))->orderBy('`sira` ASC')->run();
		while($model->fetchRow()){
			$return[] = array(
				'baslik'=>$model->baslik,
				'url'=>$url
			);
		}
		CCacheHelper::store($cache_id, serialize($return));
		return $return;
	}

}
