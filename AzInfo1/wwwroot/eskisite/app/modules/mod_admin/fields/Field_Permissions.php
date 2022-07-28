<?php

class Field_Permissions extends CField
{
	public $allowHtml = true;
	public $allowed = array();

	public function input2db($inputValue)
	{
		return serialize($inputValue);
	}

	public function db2ui($dbValue=null)
	{
		if($dbValue===null) $dbValue = $this->value;
		$allowed = @unserialize($this->value);
		if(!is_array($allowed)) $allowed = array();
		return implode(', ',$allowed);
	}
	
	private function permission_tree($menu_config) {
		//debug($menu_config);
		foreach($menu_config as $key=>$item){
			if(isset($item['action'])){
				?><li><?php 
					//echo $key.' --- '; print_r($item); 					
					?><input type="checkbox" class="check_all_perms"> - <?php 
					
					$mod = isset($item['mod']) ? $item['mod'] : 'mod_admin';
					$label = _mlang($key, 'main', $mod);
					echo '<b>'.$label.'</b> ';
					
					//$arr = explode('/',$item['action'],2);
					$arr = explode('/',$item['action']);
					$controller = $arr[0];
					unset($arr[0]);
					unset($arr[1]);
					$params = implode('/',$arr);
					if(!empty($params)){
						$params = '/'.$params;
					}
					if(isset($item['permissions'])){
						$actions = $item['permissions'];
					}else {
						$actions = array(
							'List'=>$mod.'/'.$controller.'/list'.$params,
							'Edit'=>$mod.'/'.$controller.'/edit'.$params,
							'Delete'=>$mod.'/'.$controller.'/delete'.$params,
						);
						if(isset($item['confirm_permission']) && $item['confirm_permission']){
							$actions['Confirm'] = $mod.'/'.$controller.'/#confirm';
						}
					}
					
					if(isset($item['add_permissions'])){
						$actions = array_merge($actions,$item['add_permissions']);						
					}
					
					foreach($actions as $action_name=>$action)
					{
						$action_name = _mlang($action_name,'main','mod_admin');						
						$checked = in_array($action,$this->allowed);
						?><input type="checkbox" <?=$checked?'checked="checked"':''?> name="<?=$this->name?>[]" value="<?=$action?>"><?=$action_name?>&nbsp;<?php 
					}
					
				?></li><?php 
			}else {
				?><li><b><?=  _mlang($key, 'main', 'mod_admin')?></b> <ul><?php $this->permission_tree($item); ?></ul></li><?php 				
			}
		}
	}
	
	public function showInput(){
		$allowed = @unserialize($this->value);
		if(!is_array($allowed)) $allowed = array();		
		$this->allowed = $allowed;
		$menu_config = ModAdminMenuHelper::getFullMenuConfig();
		//debug($menu_config);
		?><ul class="permtree"><?php 
		$this->permission_tree($menu_config);
		?></ul>
		<script type="text/javascript">
		$('.check_all_perms').live('click',function(){
			var $th = $(this);
			var checked = $th.is(':checked');
			var $scope = $th.parents('li').eq(0);
			var $items = $scope.find('input[type=checkbox]');
			$items.attr('checked',checked);
		});
		</script>
		<style type="text/css">			
			.permtree , .permtree ul{list-style: none;margin:0;padding:0 20px;}
			.permtree li {line-height:1.5;}
		</style>
		<?php 
	}	
}
