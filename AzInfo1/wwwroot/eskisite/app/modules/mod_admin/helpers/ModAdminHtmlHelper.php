<?php

class ModAdminHtmlHelper extends CHelper
{
	public static function summary($str,$len,$end='...',$encoding="utf-8"){
		$str = strip_tags($str);
		$tmp = mb_substr($str, 0, $len,$encoding);
		
		$len_tmp = strlen($tmp);
		$tmp = trim($tmp);
		if($tmp!=$str){
			$pos = mb_strrpos($tmp, ' ');
			$tmp = mb_substr($tmp, 0, $pos);
		}		
		return $tmp.( ( empty($tmp) || $tmp==$str )?'':$end );
	}
}
