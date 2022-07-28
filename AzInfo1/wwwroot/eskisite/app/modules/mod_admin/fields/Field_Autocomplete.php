<?php

class Field_Autocomplete extends CField
{
	public $options = array();
	protected $_gotOptions = false;
	
	public $trigger_field = array();
		
	protected function getOptions()
	{
		$options = $this->options;
		if(!empty($this->related))
		{			
			$relClass = $this->ownerModel->_relations[$this->related]['class'];
			$relModel = new $relClass();
			$remote_id_col = isset($this->ownerModel->_relations[$this->related]['remote_id_col']) ? $this->ownerModel->_relations[$this->related]['remote_id_col'] : null;
			
			$relModel->orderBy($relModel->_defaultOrderBy)->withAll()->run();
			
			while($relModel->fetchRow()){				
				$options[ !empty($remote_id_col)?$relModel->$remote_id_col :$relModel->getId() ] = $relModel->getLabel();
			}			
		}else {
			// get all text values as DISTINCT options
			$f = $this->name;
			$this->ownerModel->select('DISTINCT (`'.$f.'`)')->run();
			while($this->ownerModel->fetchRow()){
				$val = $this->ownerModel->$f;
				$options[$val] = $val;
			}
		}
		$this->options = $options;
		$this->_gotOptions = true;
	}
	
	public function __toString()
	{
		return $this->value;
	}
	
	public function db2ui($value=null)
	{
		if($value===null) $value = $this->value;
		
		if(!$this->_gotOptions)
		{
			$this->getOptions();
		}
		return isset($this->options[$value])?$this->options[$value] : $value;
	}
	
	public function factionAclist(){
		$this->getOptions();
		$rows = array();
		$term = isset($_GET['term'])?trim($_GET['term']):'';
		foreach($this->options as $val=>$str){
			$label = $str;
			if(mb_stristr($label, $term, false, 'UTF-8')){
				$rows[]= array(
					'id'=>$val,				
					'value'=>$label,
				);
			}
		}
		echo html_entity_decode(json_encode($rows), ENT_NOQUOTES, 'UTF-8');
	}
	
	public function showInput()
	{
		if(!$this->_gotOptions)
		{
			$this->getOptions();
		}
		
		$controller = $this->controllerName;
		if(empty($controller)){
			$aa = _getAppData('active_action');
			$arr = explode('/', $aa, 2);
			$controller = $arr[0];
		}

		$source_action = CUrlHelper::getModXUrl('mod_admin', $controller.'/fields',array('f'=>$this->name,'do'=>'aclist') );
		
		if(!empty($this->related))
		{
			?>
			<input type="hidden" name="<?=$this->name?>" id="<?=$this->id?>" value="<?=$this->value?>" />
			<input type="text" class="wide" id="<?=$this->id?>_ac" <?=$this->getHtmlAttrs()?> />
			<div id="<?=$this->id?>_aclabel"> <span class="remove" style="<?= empty($this->value)?'display:none;':'' ?>">[X]</span> <span class="label"><?=$this->db2ui($this->value)?></span></div>
			<script type="text/javascript">
			function refresh_<?=$this->id?>(){
				var val = $('#<?=$this->id?>').val();
				if(val==''){
					$('#<?=$this->id?>_ac').show().focus();
				}else {
					$('#<?=$this->id?>_ac').hide();
				}
			}			
			$(function(){
				$('#<?=$this->id?>_ac').autocomplete({
					source:"<?=$source_action?>",				
					select: function( event, ui ) {
						$('#<?=$this->id?>_aclabel .label').html(ui.item.value);
						$('#<?=$this->id?>_aclabel .remove').show();
						$('#<?=$this->id?>').val(ui.item.id).trigger('change');					
					},
					close: function(event, ui) {
						$('#<?=$this->id?>_ac').val('');
						refresh_<?=$this->id?>();
					}
				});
				$('#<?=$this->id?>_aclabel .remove').click(function(){				
					var label = $(this).siblings('.label');
					$('#<?=$this->id?>').val('').trigger('change');
					label.html('');
					$(this).hide();
					refresh_<?=$this->id?>();
				}).css('cursor','pointer');
				
				refresh_<?=$this->id?>();
			});
			</script>
			<?php 
		}else {
			?>
			<input type="text" class="wide" name="<?=$this->name?>" id="<?=$this->id?>" value="<?=$this->value?>" />
			<script type="text/javascript">
			$(function(){
				$('#<?=$this->id?>').autocomplete({
					source:"<?=$source_action?>"/*,					
					close: function(event, ui) {
						$('#<?=$this->id?>_ac').val('');
					}*/
				});				
			});
			</script>
			<?php 
		}
	}
}
