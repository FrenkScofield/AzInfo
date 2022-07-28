<?php

class CFilterHelper extends CHelper
{
	public static function filterRequestSegments($rsArr)
	{
		$return = array();
		foreach($rsArr as $value)
		{
			$value = preg_replace( '/[^a-zA-Z0-9_\-@.]/', '', $value );
			$value = trim($value);
			if(!empty($value)) $return[] = $value;			
		}
		return $return;
	}
	
	public static function filterDirectoryName($str)
	{
		return strtolower(trim( preg_replace( '/[^a-zA-Z0-9_]/', '', $str ) ));
	}
	
	public static function filterViewFileName($str)
	{
		return strtolower(trim( preg_replace( '/[^a-zA-Z0-9_\-]/', '', $str ) ));
	}
	
	public static function filterFormInput($value)
	{
		if($value===false)
			return false;
		
		if(!is_array($value))
		{
			return htmlspecialchars( trim($value) ,ENT_QUOTES,'UTF-8');
		}
		else return $value;		
	}
	
	public static function filterFormHtmlInput($value)
	{
		if($value===false)
			return false;
		
		return trim($value);
	}
	
	public static function validIdParam(&$param)
	{
		if( isset($param) && $param==($int=intval($param)) && $int>0 ){
			return $int;
		}
		return false;
	}
}
