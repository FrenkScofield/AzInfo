<?php

class Main extends CController
{
	public function actionIndex()
	{		
		$this->template = 'genel';

		//die('LINE:'.__LINE__); return;
		
		$this->addTitle(_l('Arama'));
		
		$this->addBc(array(
			'title'=>_l('Arama'),
			'href'=>'#'
		));
		
		//AppHelper::bolum_ayarlari('arama');
		
		_setAppData('ustbaslik', _l('ARAMA'));
		
		$action_url = CUrlHelper::getModXUrl('mod_search','main/index');
		$this->setPageUrl($action_url);
		
		$data = array(
			'rows'=>array()
		);
		
		
		
		if(CCoreHelper::checkToken() && isset($_POST['q']) && !empty($_POST['q']))
		{
			$q = trim($_POST['q']);
			if(empty($q))
			{
				CUrlHelper::redirect('main');
			}
			/*
			elseif(mb_strlen($q,'utf-8')<2)
			{
				$data['hata'] = _l('Arama yapmak için lütfen en az 2 karakter giriniz!');
			}*/
			else
			{				
				$data['ustbaslik'] = _l('ARAMA');
				$data['q_html'] = htmlentities($q,ENT_QUOTES,'utf-8');
				//$data['rows'] = $this->getSearchResults($q);
				
				$results = array();
				
				// Ana uygulamadaki helper varsa kullan
				$helperClass = 'SearchHelper';
				$helperPath = APP_PATH.'/helpers/'.$helperClass.'.php';
				
				if(is_file($helperPath) && method_exists($helperClass,'getSearchResults'))
				{												
					require_once $helperPath;
					//die('Class:'.$helperClass);
					$x = new $helperClass();
					$data['rows'] = array_merge(
						$data['rows'],							
						$x->getSearchResults($q)
					);
				}
				
				
				// tum modulleri kontrol et
				$config = _getAppData('config');
				$modules = isset($config['main']['modules'])?$config['main']['modules']:array();				
				//echo '<pre>'.print_r($modules,true).'</pre>'; die();
				
				foreach($modules as $key=>$m)
				{
					$mod = isset($m['module'])?$m['module']:$key;
					$helperClass = ucfirst($mod).'_searchHelper';					
					$helperPath = APP_PATH.'/modules/'.$mod.'/helpers/'.$helperClass.'.php';
										
					if(is_file($helperPath) && method_exists($helperClass,'getSearchResults'))
					{												
						require_once $helperPath;
						//die('Class:'.$helperClass);
						$x = new $helperClass();
						$data['rows'] = array_merge(
							$data['rows'],							
							$x->getSearchResults($q)
						);
					}
				}				
				$this->render('results',$data);
			}
		}
		else
		{
			CUrlHelper::redirect('main/index');
		}
	}	
	
}
