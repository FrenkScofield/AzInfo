<?php 
class CCacheHelper extends CHelper
{	
	public static function generateCacheId()
	{
		$cache_id = 'url:';
		$page_url = _getAppData('page_url');
		
		$config = _getAppData('config',true);
		$urlType = $config['main']['urlType'];
				
		if(!empty($page_url))
		{
			return  'PAGE_URL:'.$page_url;
		}
		elseif($urlType=='canonical')
		{
			return 'RS:'._getAppData('requestString');
		}
		else
		{
			return 'URI:'.$_SERVER['REQUEST_URI'];
		}
	}
	
	public static function runUrlCache($life=180) // returns whether cache started or not
	{
		if(count($_POST)>0 || _getAppData('cache_started') || _getAppData('is_localhost'))
		{
			return false;
		}
		$id = CCacheHelper::generateCacheId();
		$data = CCacheHelper::get($id);
		if($data===false) // no valid cache file
		{
			// start new cache buffer
			ob_start();
			_setAppData('cache_started',true);
			_setAppData('cache_id',$id);
		}
		else // valid cache file
		{
			echo $data; // echo current cache data
			exit; // end execution
		}
	}
	
	public static function checkPage($id,$life=180){
		if(/*count($_POST)>0 ||*/ _getAppData('cache_started') /*|| _getAppData('is_localhost')*/)
		{
			return false;
		}
		
		$data = CCacheHelper::get($id,$life);
		if($data===false) // no valid cache file
		{
			// start new cache buffer
			ob_start();
			_setAppData('cache_started',true);
			_setAppData('cache_id',$id);
		}
		else // valid cache file
		{
			echo $data; // echo current cache data
			exit; // end execution
		}
	}
	
	public static function endUrlCache()
	{
		if(_getAppData('cache_started'))
		{
			$data = ob_get_clean();
			$cache_id = _getAppData('cache_id');			
			CCacheHelper::store($cache_id,$data);
			echo $data; // echo current cache data
		}
	}
	
	
	public static function runCache($id,$life=180,$return = false)
	{
		$data = CCacheHelper::get($id);
		if($data===false) // no valid cache file
		{			
			ob_start();
			//_setAppData('cache_started',true); // only for url caches yet
			//_setAppData('cache_id',$id); // only for url caches yet
			return false;
		}
		else // valid cache file
		{
			if($return)
			{
				return $data;
			}
			else
			{
				echo $data;			
				return true;
			}
		}
	}
	public static function endCache($id,$return = false)
	{
		$data = ob_get_clean();
		CCacheHelper::store($id,$data);
		if($return)
			return $data;
		else
			echo $data;
	}
	
			
	public static function get($id,$life=180)
	{
		$tmpDir = APP_PATH.'/tmp';
		if(!is_dir($tmpDir))
		{
			@mkdir($tmpDir,0777);
		}
		$cacheDir = $tmpDir.'/cache';
		if(!is_dir($cacheDir))
		{
			@mkdir($cacheDir,0777);
		}
		$cacheFile = $cacheDir.'/'.md5($id);
		
		if( is_file($cacheFile) && ( $life<0 ||  (time()-filemtime($cacheFile))<$life ) )
		{
			return file_get_contents($cacheFile);
		}
		else
		{
			return false;
		}		
	}
	
	public static function store($id,$data)
	{
		$tmpDir = APP_PATH.'/tmp';
		if(!is_dir($tmpDir))
		{
			mkdir($tmpDir,0777);
		}
		$cacheDir = $tmpDir.'/cache';
		if(!is_dir($cacheDir))
		{
			mkdir($cacheDir,0777);
		}
		$cacheFile = $cacheDir.'/'.md5($id);
		@file_put_contents($cacheFile,$data);
		return $data;
	}
}
