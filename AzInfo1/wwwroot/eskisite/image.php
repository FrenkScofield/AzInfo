<?php

require "init.php";

define('CACHE_PATH',MEDIA_PATH.'/cache');

if(isset($_GET['img']) && is_string($_GET['img'])){
	$img = $_GET['img'];	
	$img = preg_replace( '/[^a-zA-Z0-9_\-.]/', '', $img );
	$img = str_replace(array('..'), '', $img);
	
	if(is_file(CACHE_PATH.'/'.$img)){		
		$mime = CUploadHelper::getMimeType($img);		
		header('Location:'. MEDIA_DIR_URL.'/cache/'. $img);
		exit;
	}
	
	$parts = explode('_', $img, 2);
	$key = $parts[0];
	
	$src_filename = isset($parts[1])?$parts[1]:'';
	$src_filename = preg_replace( '/[^a-zA-Z0-9_\-.\/]/', '', $src_filename );
	$src_filename = str_replace(array('..'), '', $src_filename);
	
	if(empty($key) || !isset($src_filename) || empty($src_filename) ){
		echo __LINE__ ;
		exit;
	}
	
	require APP_PATH.'/config/main.php';
	$size_options = isset($_config['main']['image_size_options']) && is_array($_config['main']['image_size_options']) ? $_config['main']['image_size_options'] : array();
	if(isset($size_options[$key])){
		$size = $size_options[$key];
		$src = IMAGES_PATH.'/'.$src_filename;
		$res = CUploadHelper::uploadImage(array(			
			'input_file'=>$src,
			'img_path'=>IMAGES_PATH.'/',
			'img_target_path'=>CACHE_PATH.'/',
			'size_options'=>array($size),
		));
		if($res){
			if(is_file(CACHE_PATH.'/'.$src_filename)){
				@unlink(CACHE_PATH.'/'.$src_filename);
			}
			$mime = CUploadHelper::getMimeType($img);
			header('Content-type:'.$mime);						
			echo file_get_contents(CACHE_PATH.'/'.$key.'_'.$src_filename);			
			exit;
		}
	}
}

