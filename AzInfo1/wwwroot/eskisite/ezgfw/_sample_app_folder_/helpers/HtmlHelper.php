<?php

class HtmlHelper extends CHelper {
	
	// Textarea içeriğini tekil liste yada sütunlu birden fazla liste olarak döner
	public static function lines($str,$cols=1){
		$lines = explode(PHP_EOL,$str);
		if($cols==1){
			return $lines;
		}
		else {
			$size = ceil(count($lines)/$cols);
			$groups = array_chunk($lines, $size);
			$n = count($groups);
			$diff = $cols-$n;
			for($i=0;$i<$diff;$i++){
				$groups[] = array();
			}
			return $groups;
		}
	}
	
	public static function kisalt($str,$len,$end='...',$encoding="utf-8"){		
		$str = strip_tags($str);
		$string = $str;
		 if ( strlen($string) > $len ) {
			$pos = ( $len -  mb_stripos(strrev( mb_substr($string, 0, $len,$encoding)), ' ',0,$encoding) );
			$sum = mb_substr($string, 0, $pos-1, $encoding);
			$chr = $sum[ mb_strlen($sum,$encoding)-1];
			if ( mb_strpos($chr, '.,!?;:',0,$encoding) ) {
				// STRIP LAST CHAR
				$sum = mb_substr($sum, 0, strlen($sum)-1, $encoding);
			}
			// ADD ELLIPSIS
			return $sum.$end;
		} else {
			return $string;
		}
	}
	
	public static function cumle_bol($str,$n=2,$auto_implode=null){
		$arr = explode(' ',$str);
		$arr = array_chunk($arr,ceil(count($arr)/$n));
		$return = array();
		foreach($arr as $key=>$words){
			$return[] = implode(' ',$words);
		}
		if($auto_implode!=null){
			$return = implode($auto_implode,$return);
		}
		return $return;
	}
	
	public static function bos_mu($str){
		$str = trim(strip_tags($str));
		return  empty($str) ? true : false;
	}
	
	public static function list_pager($paging,$page_url){
		if($paging['totalPages']>1){
			/*?>
			<ul class="uk-pagination">
				<li><a href="">1</a></li>
				<li><a href="">3</a></li>
				<li><a href="">4</a></li>
				<li><a href="">5</a></li>
				<li class="uk-active"><span>6</span></li>
				<li><a href="">7</a></li>
				<li><a href="">8</a></li>
				<li><a href="">9</a></li>
			</ul>
			*/?>				
			<ul class="uk-pagination"><?php

			$p = $paging['currentPage'];

			$alt_limit = $p-5;
			if($alt_limit<1){
				$alt_limit = 1;
			}
			$ust_limit = $alt_limit + 9;
			if($ust_limit>$paging['totalPages']){
				$ust_limit = $paging['totalPages'];
			}

			$params = $_GET;
			
			if($p>1){
				$params['p'] = ($p-1);
				if($params['p']==1){
					unset($params['p']);
				}
				$qs = http_build_query($params);
				?><li><a href="<?=$page_url.(!empty($qs)?'?':'').$qs?>">&laquo;</a></li><?php
			}else {
				/*?><li><a href="javascript:void();">&laquo;</a></li><?php*/
			}
			
			if($alt_limit>1 && $p!=$alt_limit){
				$params['p'] = ($alt_limit-1);
				if(($alt_limit-1)==1){
					unset($params['p']);
				}
				$qs = http_build_query($params);
				?><li><a href="<?=$page_url.(!empty($qs)?'?':'').$qs?>">...</a></li><?php
			}							
			for($i=$alt_limit;$i<=$ust_limit;$i++){
				if($i==$paging['currentPage']){
					?><li class="uk-active"><span><?=$i?></span></li><?php
				}else {
					$params['p'] = $i;
					if($i==1){
						unset($params['p']);
					}
					$qs = http_build_query($params);
					?><li><a href="<?=$page_url.(!empty($qs)?'?':'').$qs?>"><?=$i?></a></li><?php
				}

			}
			if($ust_limit<$paging['totalPages'] && $p!=$ust_limit){
				$params['p'] = ($ust_limit+1);
				$qs = http_build_query($params);
				?><li><a href="<?=$page_url.(!empty($qs)?'?':'').$qs?>">...</a></li><?php
			}
			if($p<$paging['totalPages']){
				$params['p'] = $p+1;
				if($params['p']==1){
					unset($params['p']);
				}
				$qs = http_build_query($params);
				?><li><a href="<?=$page_url.(!empty($qs)?'?':'').$qs?>">&raquo;</a></li><?php
			}else {
				/*?><li><a href="javascript:void();">&raquo;</a></li><?php*/
			}
			
			?>
			</ul>
		<?php
		}
	}
	
}
