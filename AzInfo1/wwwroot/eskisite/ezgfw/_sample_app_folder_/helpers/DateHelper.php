<?php 

switch(LANG){
	case 'en':
		setlocale(LC_TIME, 'en_US.UTF-8');
		break;
	default:
		$uc = strtoupper(LANG);
		$lc = strtolower(LANG);
		setlocale(LC_TIME, $lc.'_'.$uc.'.UTF-8');
		break;	
}

class DateHelper extends CHelper
{
	public static function turkceTarih($tar=NULL){
		if(empty($tar)) return '';
		$year  = substr($tar, 0,4 );
		$month = substr($tar, 5,2 );
		$day   = substr($tar, 8,2 );
		if($month==0) $month="01";
		if($day==0) $day="01";
		$turkce= $day.".".$month.".".$year;
		return $turkce;
	}
	
	public static function tarihSaat($dt){
		if(empty($dt)) return '';		
		list($d,$t) = explode(' ',$dt);		
		return self::turkceTarih($d).' '.$t;
	}
	
	public static function tarihGun($d){
		if(empty($d)){
			return '';
		}
		$ts = strtotime($d);
		return strftime('%e %B %G %A',$ts);
	}
	
	public static function ayGunYil($d){
		if(empty($d)){
			return '';
		}
		$ts = strtotime($d);
		$str = str_replace('  ' ,' ',strftime('%B %e %G',$ts));
		return $str;
	}
	
	public static function gunAyYil($d){
		if(empty($d)){
			return '';
		}
		$ts = strtotime($d);
		$str = str_replace('  ' ,' ',strftime('%e %B %G',$ts));
		return $str;
	}
}
