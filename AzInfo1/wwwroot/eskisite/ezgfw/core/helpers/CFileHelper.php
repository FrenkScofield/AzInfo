<?php

class CFileHelper extends CHelper
{
	public static function parseFiles($data,$getTitles=false)
	{		
		$files = array();
		foreach(explode(':',$data) as $file){
			$parts = explode('|',$file);
			$_file = $parts[0];
			$_title = isset($parts[1])?$parts[1]:'';
			if($getTitles){
				$files[]=array('file'=>$_file,'title'=>$_title);
			}
			else{
				$files[]=$_file;
			}
		}
		return $files;
	}
	
	public static function parseFile($data,$getTitles=false)
	{
		$files = self::parseFiles($data,$getTitles);
		return $files[0];
	}
	
	
	public static function getFirst($data,$dir=''){
		return self::getFirstValid($data,$dir);
	}
	
	public static function getFirstValid($data,$dir=''){
		foreach(self::parseFiles($data) as $f){
			if(is_file(FILES_PATH.'/'.$dir.$f)){
				return $f;
			} 
		}
		return false;
	}
	
	public static function getAllValid($data,$dir=''){
		$return = array();
		foreach(self::parseFiles($data) as $f){
			if(is_file(FILES_PATH.'/'.$dir.$f)){
				$return[] =  $f;
			}
		}
		return $return ;
	}
}
