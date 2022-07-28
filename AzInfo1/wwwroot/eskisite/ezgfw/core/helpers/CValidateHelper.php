<?php

class CValidateHelper extends CHelper
{
	
	public static function required(& $var)
	{
		if(!isset($var))
		{
			return false;
		}
		$var = trim($var);
		return !empty($var);
	}
	
	public static function email($var)
	{		
		return empty($var) || (preg_match('/^[a-z0-9._+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i',$var)===1);
	}
	
	public static function url($var)
	{
		return empty($var) || preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $var); 
	}
	
	public static function recaptcha()
	{
		$recaptcha = new Plugin_Recaptcha();
		return $recaptcha->validate();
	}
	
	public static function captcha($var)
	{
		if(!isset($_SESSION['captcha'])){
			return false;
		}
		$captcha = strtolower($_SESSION['captcha']);
		$input = strtolower($var);
		return ($captcha==$input);
	}
	
	public static function date_tr($var){
		$var = trim($var);
		if(empty($var)) return true;
		
		$arr = explode('.',$var);
		if(count($arr)!=3){
			return false;
		}
		else{
			list($day,$mon,$year) = $arr;
		}
		$day = intval($day);
		$mon = intval($mon);

		if($day<10)
			$day = '0'.$day;
		if($mon<10)
			$mon = '0'.$mon;

		$date = $year.'-'.$mon.'-'.$day;
		
		return checkdate($mon,$day,$year);
	}
	
	public static function date($var){
		$var = trim($var);
		if(empty($var)) return true;
		
		$arr = explode('-',$var);
		if(count($arr)!=3){
			return false;
		}
		else{
			list($year,$mon,$day) = $arr;
		}
		$day = intval($day);
		$mon = intval($mon);
		
		return checkdate($mon,$day,$year);
	}
	
	public static function length(&$form,$var,$ruleData)
	{
		if(empty($var)) return true; // zorunlu alan ise required kullanılmalı
		
		$len = strlen($var);
		$ruleData = explode('-',$ruleData);
		if(count($ruleData)==2)
		{			
			$min = min($ruleData);			
			$max = max($ruleData);
			return $len<=$max && $len>=$min ;
		}
		else
		{
			return $len==intval($ruleData[0]);
		}
	}
	
	public static function options(&$form,$var,$ruleData){
		if(empty($var)) return true; // zorunlu alan ise required kullanılmalı
		
		$options = explode('|',$ruleData);
		return in_array($var,$options);
	}
	
	public static function repeat(&$form,$var,$ruleData){		
		return $var==$form->$ruleData;
	}
	
	
	
	
}
