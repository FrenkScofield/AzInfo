<?php

class Field_List extends CField {

	public $options = array();
	protected $_gotOptions = false;
	
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
		}
		$this->options = $options;
		$this->_gotOptions = true;
	}
	
	private function getItems($value){
		$glue = !empty($this->related)?',':'|'; // related tanımı varsa ayraç olarak , yoksa | kullanılacak
		return explode($glue,$value);
	}
	
	public function __toString()
	{
		return $this->value;
	}
	
	public function getItemLabel($val){
		return isset($this->options[$val])?$this->options[$val] : $val;
	}
	
	public function db2ui($value=null)
	{
		if($value===null) $value = $this->value;
		
		if(!$this->_gotOptions)
		{
			$this->getOptions();
		}
		
		$return = '';		
		foreach($this->getItems($value) as $val){
			$return .= $this->getItemLabel($val) .'<br>';
		}
		return $return;
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
		
		?><input type="hidden" name="<?=$this->name?>" id="<?=$this->id?>" value="<?=$this->value?>" /><?php 
		
		if(!empty($this->related))
		{
			?>
			<input type="text" class="wide" id="<?=$this->id?>_ac" <?=$this->getHtmlAttrs()?> />
			<script type="text/javascript">
			$(function(){
				$('#<?=$this->id?>_ac').autocomplete({
					source:"<?=$source_action?>",				
					select: function( event, ui ) {
						addItem_<?=$this->id?>(ui.item.id, ui.item.value);
						listUpdated_<?=$this->id?>();
					},
					close: function(event, ui) {
						$('#<?=$this->id?>_ac').val('');
						listUpdated_<?=$this->id?>();
					}
				});
			});
			</script>
			<?php 
		}else {
			?>
			<input type="text" class="wide" id="<?=$this->id?>_ac" <?=$this->getHtmlAttrs()?> />
			<script type="text/javascript">
			$(function(){
				$('#<?=$this->id?>').autocomplete({
					source:"<?=$source_action?>" 
				});
			});
			</script>
			<?php 
		}
		
		
		$vals = $this->getItems($this->value);
		
		?><ul id="list_<?=$this->id?>" class="textlist"><?php 
		foreach($vals as $val){
			if(empty($val)){
				continue;
			}
			?><li class="ui-state-default" data-value="<?= $val ?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> <span class="label"><?= $this->getItemLabel($val)?></span> &nbsp; <span class="ui-icon ui-icon-close remove" onclick="$(this).parents().eq(0).remove();listUpdated_<?=$this->id?>();"></span></li><?php 
		}
		?></ul>
		<script type="text/javascript">
		$( "#list_<?=$this->id?>").sortable({
			update: function( event, ui ) {
				listUpdated_<?=$this->id?>();
			}
		});
		function listUpdated_<?=$this->id?>(){
			var items = [];
			var glue = '<?= (!empty($this->related)?',':'|') ?>';
			$('#list_<?=$this->id?> > li').each(function(){
				items[items.length] = $(this).attr('data-value');
			});			
			$('#<?=$this->id?>').val(items.join(glue));
		}
		function addItem_<?=$this->id?>(value,label){
			$('#list_<?=$this->id?>').append('<li class="ui-state-default" data-value="'+value+'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> <span class="label">'+label+'</span> &nbsp; <span class="ui-icon ui-icon-close remove" onclick="$(this).parents().eq(0).remove();listUpdated_<?=$this->id?>();"></span></li>');
		}
		</script>
		<style type="text/css">
			.textlist {list-style-type:none;margin:0;padding:0;}			
			.textlist li {clear:both;padding:2px;}
			.textlist li span ,.textlist li input {float:left;}
			.textlist li .ui-icon-arrowthick-2-n-s, .textlist li .remove{ cursor:pointer;}
		</style>
		<?php 
		
	}
	
}
