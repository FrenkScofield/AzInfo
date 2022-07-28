<?php

class Field_Checkboxlist extends CField
{
	public $options = array();
	public $groupByDelimiter = '';
	
	protected $_gotOptions = false;
			
	protected function getOptions()
	{
		$options = $this->options;
		if(!empty($this->related))
		{
			$relClass = $this->ownerModel->_relations[$this->related]['class'];
			$relModel = new $relClass();
						
			$relModel->orderBy($relModel->_defaultOrderBy)->run();
			
			while($relModel->fetchRow()){				
				$options[ $relModel->getId() ] = $relModel->getLabel();
			}			
		}
		$this->options = $options;
		$this->_gotOptions = true;
	}
	
	public function db2ui($value=null)
	{
		if($value===null) $value = $this->value;
		
		if(!$this->_gotOptions)
		{
			$this->getOptions();
		}		
		$list = array();
		foreach(explode(',',$value) as $val)
		{
			$list[] = isset($this->options[$val])?$this->options[$val] : $val;
		}
		return implode('<br>',$list);
	}
	
	public function input2db($inputValue)
	{
		$return = '';		
		if(is_array($inputValue))
		{
			$return = implode(',',$inputValue);
		}
		return $return;
	}
	
	
	public function showInput()
	{
		if(!$this->_gotOptions)
		{
			$this->getOptions();
		}
		$checked = explode(',',$this->value);
		
		$groupByDelimiter = $this->groupByDelimiter;
		if(!empty($groupByDelimiter)){
			$groups = array();
			foreach($this->options as $key=>$label)
			{
				$parts = explode($groupByDelimiter,$label);
				if(count($parts)==2){
					$group = $parts[0];
					$item = $parts[1];
					if(!isset($groups[$group])){
						$groups[$group] = array();
					}
					$groups[$group][$key] = $item;
				}
			}
			?>
			<div id="<?=$this->id?>"><?php 
			foreach($groups as $group=>$options){
				?>
				<div class="group_title"><?=$group?></div>
				<div class="group_content"><?php 
				foreach($options as $key=>$label)
				{
					?>
					<div>
						<input type="checkbox" value="<?=$key?>" name="<?=$this->name?>[]" <?=in_array($key,$checked)?'checked="checked"':''?>>
						&nbsp; <?=$label?>
					</div><?php 
				}
				?></div><?php 	
			}
			?>
			</div>
			<style type="text/css">
				.group_title {border:1px solid silver;background:#f5f5f5;padding:3px;cursor:pointer;margin-bottom:3px;}
				.group_content {display:none;}
			</style>
			<script type="text/javascript">
			$(function(){
				$('#<?=$this->id?> .group_title').click(function(){
					var target = $(this).next('.group_content');
					$('#<?=$this->id?> .group_content').not(target).slideUp('slow');
					target.slideDown('slow');
				});
			});
			</script>
			<?php 
		}
		else {
			?><table><?php 
			foreach($this->options as $key=>$label)
			{
				?><tr>
					<td><input type="checkbox" value="<?=$key?>" name="<?=$this->name?>[]" <?=in_array($key,$checked)?'checked="checked"':''?>></td>
					<td><?=$label?></td>
				</tr><?php 
			}
			?></table><?php 
		}
	}
	
}
