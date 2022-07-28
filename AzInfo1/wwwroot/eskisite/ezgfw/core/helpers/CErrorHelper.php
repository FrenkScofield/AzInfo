<?php

class CErrorHelper extends CHelper {
	
	public static function disableLog(){
		$current = _getAppData('logErrors');
		_setAppData('logErrors_tmp',$current);
		_setAppData('logErrors',false);
	}
	
	public static function restoreLog(){
		$tmp = _getAppData('logErrors_tmp');		
		_setAppData('logErrors',$tmp);
	}
	
}