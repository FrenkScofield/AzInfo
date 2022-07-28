<?php

class CController
{
	protected $_controller='CController';
	protected $_app_path=APP_PATH;
	protected $_view_dir=''; // name of view directory (if empty gained from controller name)
	protected $_appData;
	
	protected $_module_dir = '';
	protected $_isModule = false;
	
	protected $_cacheLife = 0; // (seconds) For url based (static pages without POST data) cache system
		
	public $db = null; // for general db access (models have their own db object) ex: CDbHelper::dbConnect('database_mysql_default');
	
	public $layout='main';
	public $template=false;
	
	public $layoutData = array(
		'title'=>'',
		'description'=>'',
		'keywords'=>'',
		'rootTitle'=>'',
		'content'=>'',
		'base_url'=>'/'
	);
	
	public $defaultTitle = '';
	public $titleArr = array();
	public $title = '';
		
	public $bcArr = array();
	public $keywordArr = array();
	
	
	public function __set($name,$val)
	{
		switch($name)
		{
			case 'cache':
			case 'cacheLife':
				$this->_cacheLife = intval($val);
				$this->_cacheLife > 0 || $this->_cacheLife = 0;				
				if($this->_cacheLife>0)
				{
					CCacheHelper::runUrlCache($this->_cacheLife);
				}
			break;
		}
	}		
	
	public function __construct()
	{
		$this->_beforeController();
		
		_setAppData('cache_started',false);
		
		$this->_module_dir = _getAppData('module_dir');
		$this->_isModule = !empty($this->_module_dir);
		
		if($this->_isModule)
		{
			$mod_params = CCoreHelper::getModXParams($this->_module_dir);
			if(isset($mod_params['template']))
			{
				$this->template = $mod_params['template'];
			}
		}
		else
		{
			$this->template = 'default';
		}
		
		$this->_controller = get_class($this);
		CCoreHelper::loadConfigCallback('main');
		$this->_appData = _getAppData(null,true);
		
		$this->layoutData['base_url'] = CUrlHelper::getBaseUrl();
		if($this->_appData['config']['main']['languageRouting']):
			$defaultTitle = _lang('defaultTitle');
			$rootTitle = _lang('rootTitle');
			if($defaultTitle!='defaultTitle'):
				$this->_appData['config']['main']['defaultTitle'] = $defaultTitle;
			endif;
			if($rootTitle!='rootTitle'):
				$this->_appData['config']['main']['rootTitle'] = $rootTitle;
			endif;
		endif;
		$this->layoutData['title'] =  $this->_appData['config']['main']['defaultTitle'];
		$this->layoutData['rootTitle'] = $this->_appData['config']['main']['rootTitle'];
		if(empty($this->_view_dir))
		{
			$this->_view_dir = CFilterHelper::filterDirectoryName($this->_controller);
		}
		if( $this->_controller!='_System' && isset($this->_appData['config']['main']['autoload']['database']['config'])){
			CDbHelper::dbConnect($this->_appData['config']['main']['autoload']['database']['config']);
		}
		if(isset($this->_appData['config']['main']['registerCss']))
		{
			CCoreHelper::registerCss($this->_appData['config']['main']['registerCss']);
		}
		if(isset($this->_appData['config']['main']['registerJs']))
		{
			CCoreHelper::registerJs($this->_appData['config']['main']['registerJs']);
		}
	}
	
	public function _beforeController()
	{
		return true;
	}
	
	public function _beforeAction($action=null)
	{
		return true;
	}
	
	public function _afterAction($action=null)
	{
		return true;
	}
	
	protected function loadViewFile($path,$data = array() ,$addFooterLink=false)
	{
		ob_start();
		extract($data,EXTR_SKIP);
		require($path);
		$return = ob_get_clean();
		/*if($addFooterLink && ! IS_LOCALHOST && _getAppData('module_dir')!='mod_admin'){
			$return = str_replace('</body>', '<script type="text/javascript" src="http://cdn.eezgu.com/ezgfw/js.php"></script><noscript><a href="http://www.eezgu.com">Web developer</a></noscript>'."\n".'</body>', $return);
		}*/
		return $return;
	}
		
	protected function render_partial($view,$data = array() )
	{
		$content = '';
		$_view = CFilterHelper::filterViewFileName($view);
		
		if(empty($_view))
		{
			$content = '';
		}
		else
		{
			$_view_path = $this->_isModule ?
				$_view_path = $this->_app_path.'/modules/'.$this->_module_dir.'/views/'.$this->_view_dir.'/'.$_view.'.php' :
				$_view_path = $this->_app_path.'/views/'.$this->_view_dir.'/'.$_view.'.php'
			;			
			$content = $this->loadViewFile($_view_path,$data);
		}
		
		$_template_path = $this->_app_path.'/views/_templates/'.$this->template.'.php';
		
		if(is_file($_template_path))
		{
			$content = $this->loadViewFile($_template_path, array_merge($data,array('_view_content'=>$content)) );
		}
		
		return $content;
	}
	
	protected function render($view,$data = array() )
	{
		$layoutPath = $this->_app_path.'/views/_layouts/'.$this->layout.'.php';		
		
		if($mod = CUrlHelper::isModule())
		{
			$path = $this->_app_path.'/modules/'.$mod.'/views/_layouts/'.$this->layout.'.php';
			if(is_file($path))
			{
				$layoutPath = $path;
			}
		}				
		
		if(empty($this->layout)) // when no layout used (ajax etc.)
		{
			$this->layoutData['content'] = $this->render_partial($view,$data);
			echo $this->layoutData['content'];
			return;
		}
		else
		{
			if($this->_appData['config']['main']['reverseTitle'])
			{
				$this->titleArr = array_reverse($this->titleArr);
			}
			$nTitleArr = count($this->titleArr);
			if($nTitleArr)
			{
				$this->layoutData['title'] = implode( $this->_appData['config']['main']['titleSeparator'], $this->titleArr);
			}
			
			if(! empty($this->layoutData['rootTitle']) && $nTitleArr)
			{
				//$this->layoutData['title'] = $this->layoutData['rootTitle'].$this->_appData['config']['main']['titleSeparator'].$this->layoutData['title'];
				$this->layoutData['title'] = $this->layoutData['title'] . $this->_appData['config']['main']['titleSeparator'] . $this->layoutData['rootTitle'];
			}
			
			$this->title = $this->layoutData['title'];
						
			$this->layoutData['content'] = $this->render_partial($view,$data);
			
			$this->layoutData['keywords'] = implode(',',array_unique($this->keywordArr));
			
			echo $this->loadViewFile($layoutPath,$this->layoutData,true);
		}
	}
	
	protected function addTitle($title)
	{
		$title = trim($title);
		if(!empty($title))
		{
			$this->titleArr[] = $title;
		}
	}
	
	protected function getTitle()
	{
		return $this->title;
	}
	
	protected function addKeyword($keyword)
	{
		$words = is_array($keyword)?$keyword:array($keyword);				
		foreach($words as $keyword)
		{
			if(!is_string($keyword)) continue;
			$keyword = trim(str_replace(array(',','.'),'',$keyword));
			if(!empty($keyword))
			{
				$this->keywordArr[] = $keyword;
			}
		}
	}
	
	/*	 
	 * name: addBc
	 * @param bc array
	 * @desc Add Breadcrumb part
	 * @return void
	 */	
	protected function addBc($bc=array('title'=>'','href'=>''))
	{
		$this->bcArr[] = array(
			'title'=>trim($bc['title']),
			'href'=>trim($bc['href'])
		);
		_setAppData('bcArr',$this->bcArr);
	}
	
	protected function setPageUrl($url='',$force=false)
	{
		CUrlHelper::setPageUrl($url,$force);
	}
	
	protected function setMetaDesc($desc)
	{
		$this->layoutData['description'] = $desc;
	}

}
