<?php

class SearchHelper extends CHelper {
	
	public static function getSearchResults($q)
	{
		$q = trim($q);
		
		$rows = array();
		
		
		$model = new CModel();
		
		$q_html = htmlentities($q,ENT_QUOTES,'utf-8');
		$q_db = $model->real_escape_string($q);
				
		$search_words = array_merge(array($q),explode(' ',$q));
		
		$escaped_words = array();
		
		foreach($search_words as $i=>$word)
		{
			$x = trim($word);
			if(empty($x))
				continue;
			
			$escaped_words[] = $model->real_escape_string($x);
		}
		
		////////////////////////// SEARCH RULES ////////////////////////////////
		
		$search_rules = array(
			array(
				'model'=>'KurumsalModel',
				'searchCols'=>array('baslik_'.LANG,'yazi_'.LANG),
				'orderBy'=>'',
				//'prefix'=>_l('KURUMSAL').' &raquo; ',
				'prefix'=>'',
				//'titleCol'=>'baslik_'.LANG,
				'title'=>_l('KURUMSAL'),
				'urlType'=>'kurumsal',
				'singleResult'=>TRUE
			),
			array(
				'model'=>'HizmetModel',
				'searchCols'=>array('baslik_'.LANG,'aciklama_'.LANG),
				'orderBy'=>'',
				'prefix'=>'',
				'titleCol'=>'',
				'title'=>_l('HİZMETLER'),
				'urlType'=>'hizmetler',
				'singleResult'=>TRUE
			),
			array(
				'model'=>'UrunModel',
				'searchCols'=>array('baslik_'.LANG,'aciklama_'.LANG),
				'orderBy'=>'`Kategori`.`sira` ASC',
				'prefix'=>_l('ÜRÜNLER').' &raquo; ',
				'titleCol'=>'',
				'title'=>'',
				'titleType'=>'urunler',
				'urlType'=>'urunler',
				'singleResult'=>FALSE
			),
			array(
				'model'=>'NsfModel',
				'searchCols'=>array('isim'),
				'orderBy'=>'',
				'prefix'=>'',
				'titleCol'=>'',
				'title'=>_l('ÜRÜNLER').' &raquo; '._l("NSF'Lİ ÜRÜNLERİMİZ"),				
				'urlType'=>'nsf',
				'singleResult'=>TRUE
			),
			array(
				'model'=>'OzonModel',
				'searchCols'=>array('baslik_'.LANG,'aciklama_'.LANG,'kutu1_'.LANG,'kutu2_'.LANG,'kutu3_'.LANG),
				'orderBy'=>'`sira` ASC',
				'prefix'=>_l('ÜRÜNLER').' &raquo; '. _l('OZON SİSTEMLERİ').' &raquo; ',
				'titleCol'=>'baslik_'.LANG,
				'title'=>'',				
				'urlType'=>'ozon',
				'singleResult'=>FALSE
			),
			array(
				'model'=>'BelgeModel',
				'searchCols'=>array('baslik'),
				'orderBy'=>'',
				'filterCond'=>'`belge`.`bolum`= \'belgeler\' AND `belge`.`dil`=\''.LANG.'\'',
				'prefix'=>_l('ÜRÜNLER').' &raquo; ',
				'titleCol'=>'',
				'title'=>_l("BELGELER"),
				'urlType'=>'belgeler',
				'singleResult'=>TRUE
			),
			array(
				'model'=>'BelgeModel',
				'searchCols'=>array('baslik'),
				'orderBy'=>'',
				'filterCond'=>'`belge`.`bolum`= \'teknik_belgeler\' AND `belge`.`dil`=\''.LANG.'\'',
				'prefix'=>_l('SERTİFİKALAR').' &raquo; ',
				'titleCol'=>'',
				'title'=>_l("TEKNİK BELGELER"),
				'urlType'=>'teknik_belgeler',
				'singleResult'=>TRUE
			),
			array(
				'model'=>'BelgeModel',
				'searchCols'=>array('baslik'),
				'orderBy'=>'',
				'filterCond'=>'`belge`.`bolum`= \'kalite_belgeleri\' AND `belge`.`dil`=\''.LANG.'\'',
				'prefix'=>_l('SERTİFİKALAR').' &raquo; ',
				'titleCol'=>'',
				'title'=>_l("KALİTE BELGELERİ"),
				'urlType'=>'kalite_belgeleri',
				'singleResult'=>TRUE
			),
			array(
				'model'=>'BelgeModel',
				'searchCols'=>array('baslik'),
				'orderBy'=>'',
				'filterCond'=>'`belge`.`bolum`= \'sistem_bilgi_formatlari\' AND `belge`.`dil`=\''.LANG.'\'',
				'prefix'=>_l('SERTİFİKALAR').' &raquo; ',
				'titleCol'=>'',
				'title'=>_l("SİSTEM BİLGİ FORMATLARI"),
				'urlType'=>'sistem_bilgi_formatlari',
				'singleResult'=>TRUE
			),
			array(
				'model'=>'ReferansModel',
				'searchCols'=>array('baslik_'.LANG,'aciklama_'.LANG,),
				'orderBy'=>'',				
				'prefix'=>'',
				'titleCol'=>'',
				'title'=>_l("REFERANSLAR"),
				'urlType'=>'referanslar',
				'singleResult'=>TRUE
			),
			array(
				'model'=>'HaberModel',
				'searchCols'=>array('baslik_'.LANG,'aciklama_'.LANG,),
				'orderBy'=>'',				
				'prefix'=>'',
				'titleCol'=>'',
				'title'=>_l("HABERLER"),
				'urlType'=>'haberler',
				'singleResult'=>TRUE
			),
			
		);
		
		
		////////////////////////////////////////////////////////////////////////
		
		foreach($search_rules as $s){
			$q_conds = array();
			
			$model = new $s['model'] ;
			$tableName = $model->_tableName;
			
			foreach($escaped_words as $x_db){
				foreach($s['searchCols'] as $col){
					$q_conds[] = '`'.$tableName.'`.`'.$col.'` LIKE \'%'.$x_db.'%\'';
				}
			}
			$condition = '('.implode(' OR ',$q_conds).')';
			
			if(!empty($s['filterCond'])){
				$condition = '( '.$s['filterCond'] . ' ) AND '.$condition;
			}
			
			$model->orderBy($s['orderBy'])->withAll()->where($condition)->run();			
			//echo $model->_query; echo '<br>';
			
			while($model->fetchRow())
			{
				$title = '';
				if(isset($s['titleCol']) && !empty($s['titleCol'])){
					$title = $s['prefix'] . $model->{$s['titleCol']};
				} 
				else if(isset($s['titleType']) && !empty($s['titleType'])) {
					$title = $s['prefix'] . self::getTitle($s['titleType'], $model);
				}
				else if(isset($s['title']) && !empty($s['title'])) {
					$title = $s['prefix'] . $s['title'];
				}
				
				$rows[] = array(
					'title'=>$title,
					'href'=>self::getUrl($s['urlType'],$model)
				);
				
				if(isset($s['singleResult']) && $s['singleResult']){
					break;
				}
			}
		}
		
		return $rows;
	}
	
	public static function getUrl($type,& $model = NULL){
		switch($type){
			case 'kurumsal':
				return CUrlHelper::getUrl('main/kurumsal');
							
			case 'hizmetler':
				return CUrlHelper::getUrl('main/hizmetler');
			
			case 'urunler': // kategoriler listelenecek
				return CUrlHelper::getUrl('main/urunler',array('cid'=>$model->getId()),$model->baslik);	
				
			case 'nsf':
				return CUrlHelper::getUrl('main/nsf_urunler');
			
			case 'ozon':
				return CUrlHelper::getUrl('main/ozon_sistemleri',array('id'=>$model->getId()),$model->baslik);
				
			case 'belgeler':
				return CUrlHelper::getUrl('main/belgeler');
			
			case 'teknik_belgeler':
				return CUrlHelper::getUrl('main/teknik_belgeler');
			
			case 'kalite_belgeleri':
				return CUrlHelper::getUrl('main/kalite_belgeleri');
			
			case 'sistem_bilgi_formatlari':
				return CUrlHelper::getUrl('main/sistem_bilgi_formatlari');
			
			case 'referanslar':
				return CUrlHelper::getUrl('main/referanslar');
			
			case 'haberler':
				return CUrlHelper::getUrl('main/haberler');
			
			default:
				return 'javascript:void;';
		}
	}
	
	public static function getTitle($type,& $model = NULL){
		switch($type){
			case 'urunler': // kategoriler
				return $model->Kategori->baslik;
				break;
			
		}		
		return '';
	}
	
}
