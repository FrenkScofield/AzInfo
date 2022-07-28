<?php

class CHtmlHelper extends CHelper
{	
	public static function linkTag($rel)
	{
		switch($rel){
			case 'canonical':
				$url = trim(_getAppData('page_url'));
				if(!empty($url)){
					?><link rel="canonical" href="<?=$url?>" /><?php 
				}
			break;
		}		
	}
	
	public static function emptyHtml($html,$min_length=0,$charset='UTF-8'){
		$html = trim( html_entity_decode(strip_tags($html),ENT_QUOTES,$charset) ) ;
		return (strlen($html)<intval($min_length))?true:empty($html);
	}
	
	public static function jsTags()
	{
		$return = '';		
		foreach( _getAppData('js_files') as $file )
		{
			$return .= '<script type="text/javascript" src="'. JS_URL .'/'.$file.'"></script>';
		}
		return $return;
	}
	
	public static function cssTags()
	{
		$return = '';		
		foreach( _getAppData('css_files') as $file )
		{
			$return .= '<link rel="stylesheet" href="'. CSS_URL .'/'.$file.'" type="text/css">';
		}
		return $return;
	}
	
	public static function flashObject($src,$params=array())
	{
		$width = isset($params['width']) ? ' width="'.$params['width'].'"' : '';
		$height = isset($params['height']) ? ' height="'.$params['height'].'"' : '';		
		return '<object'.$width.$height.'><param name="movie" value="'.$src.'"><embed src="'.$src.'"'.$width.$height.'></embed></object>';
	}
	
}
