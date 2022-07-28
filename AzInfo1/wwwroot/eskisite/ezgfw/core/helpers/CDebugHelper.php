<?php

class CDebugHelper extends CHelper
{
	public static function debug($buffer='')
	{
		return '<pre class="debug">'.$buffer.'</pre>';
	}
	
	public static function debugArray($array=array())
	{
		return '<pre class="debug">'.print_r($array,true).'</pre>';
	}
	
	public static function startDebug()
	{
		ob_start();		
	}
	
	public static function endDebug()
	{
		$buffer = ob_get_clean();
		return '<pre class="debug">'.$buffer.'</pre>';
	}
}
