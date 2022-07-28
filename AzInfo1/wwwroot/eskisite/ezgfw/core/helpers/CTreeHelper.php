<?php

class CTreeHelper extends CHelper {
	
	/**
	 * Converts an array containing items (where each  item is an array/object having key=>value elements) to a tree structure according to parent relations
	 * @param array $array
	 * @param string $prikey
	 * @param string $parent_col
	 * @param string $children_col
	 * @return array
	 */
	public static function array2tree($array,$prikey='id',$parent_col='parent_id',$children_col='children'){
		$rows = array();
		foreach($array as $item){
			if(is_object($item)){
				$item = self::object2array($item);
			}
			$rows[$item[$prikey]] = array_merge($item,array($children_col=>array()) );
		}
		foreach($rows as $id=>$item){
			$parent_id = $item[$parent_col];
			if(!empty($parent_id)){
				if(isset($rows[$parent_id])){
					$rows[$parent_id][$children_col][$id] = $rows[$id];
					$rows[$id][$children_col] = & $rows[$parent_id][$children_col][$id][$children_col];				
				}
			}
		}
		foreach($rows as $id=>$item){
			$parent_id = $item[$parent_col];
			if(!empty($parent_id)){
				unset($rows[$id]);
			}
		}	
		return $rows;
	}
	
	public static function object2array($obj){
		$return = array();
		foreach($obj as $name=>$val){
			$return [$name]= $val;
		}
		return $return;
	}
	
}