<?php

class CImageHelper extends CHelper
{	
	public static function parseImages($data,$getTitles=false)
	{		
		$images = array();
		foreach(explode(':',$data) as $image){
			$parts = explode('|',$image);
			$image_file = $parts[0];
			$image_title = isset($parts[1])?$parts[1]:'';
			if($getTitles){
				$images[]=array('file'=>$image_file,'title'=>$image_title);
			}
			else{
				$images[]=$image_file;
			}
		}
		return $images;	
	}
	
	public static function parseImage($data,$getTitles=false)
	{		
		$images = self::parseImages($data,$getTitles);
		return $images[0];
	}
	
	
	public static function getFirst($data,$prefix='',$dir=''){
		return self::getFirstValid($data, $prefix, $dir,true);
	}
	
	public static function getFirstValid($data,$prefix='',$dir='',$useDefault=false){ // deprecated function name
		return self::get($data,$prefix,$dir,$useDefault);
	}
		
	public static function get($data,$prefix='',$dir='',$useDefault=false){
		is_array($prefix) || $prefix = array($prefix);
		foreach(self::parseImages($data) as $r){
			$ok = true;
			foreach($prefix as $pre){
				if(!is_file(IMAGES_PATH.'/'.$dir.$pre.$r)){
					$ok = false;
					break;
				}
			}
			if($ok){
				return $r;
			} 
		}
		if($useDefault){
			foreach(array('default.png','default.jpg') as $df){
				if(is_file(IMAGES_PATH.'/'.$df)){
					return $df;
				}
			}
		}
		return false;
	}
	
	public static function getAllValid($data,$prefix='',$dir=''){ // deprecated function name
		return self::getAll($data,$prefix,$dir);
	}
	
	public static function getAll($data,$prefix='',$dir=''){
		$return = array();
		is_array($prefix) || $prefix = array($prefix);
		foreach(self::parseImages($data) as $r){
			$ok = true;
			foreach($prefix as $pre){
				if(!is_file(IMAGES_PATH.'/'.$dir.$pre.$r)){
					$ok = false;
					break;
				}
			}
			if($ok){
				$return[] =  $r;
			}
		}
		return $return ;
	}
}
