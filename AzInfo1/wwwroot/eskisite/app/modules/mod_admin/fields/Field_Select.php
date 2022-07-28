<?php

class Field_Select extends CField
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
		return isset($this->options[$value])?$this->options[$value] : $value;
	}
	
	public function showInput()
	{
		if(!$this->_gotOptions)
		{
			$this->getOptions();
		}		
		?><select name="<?=$this->name?>" id="<?=$this->id?>">
			<option value="">-- <?=_mlang('Select','main','mod_admin')?> --</option><?php 
			
			foreach($this->options as $val=>$label)
			{
				?><option value="<?=$val?>" <?=$this->value==$val?'selected="selected"':''?>><?=$label?></option><?php 
			}			
			?>
		</select><?php 
		if(isset($this->trigger_field['field']) && isset($this->trigger_field['trigger_relation']) && isset($this->ownerForm->_fields[$this->trigger_field['field']]) )
		{			
			
			$trigger_field_params = $this->ownerForm->_fields[$this->trigger_field['field']];
			if(isset($trigger_field_params['related']))
			{
				$relClass = $this->ownerModel->_relations[$trigger_field_params['related']]['class'];
					
				?><script type="text/javascript">
				$(function(){
					var $form = $('#<?=$this->id?>').parents('form').eq(0);
					var $relField = $form.find('[name=<?=$this->trigger_field['field']?>]');
					
					function change_<?=$this->id?>()
					{
						$('#<?=$this->id?>').html('').hide();						
						var relValue = $relField.val();
						$.post(
							'<?=CUrlHelper::getModXUrl('mod_admin','fields/trigger_select_options')?>',
							{
								'trigger_model':'<?=$relClass?>',
								'trigger_value':relValue,
								'trigger_relation':'<?=$this->trigger_field['trigger_relation']?>',
							},
							function(response){
								$('#<?=$this->id?>').html(response);
								$('#<?=$this->id?> option[value="<?=$this->value?>"]').attr('selected','selected');
								$('#<?=$this->id?>').show();
							}
						);
					}										
					$relField.change( change_<?=$this->id?> ).trigger('change');
					$form.bind('reset',change_<?=$this->id?>);
				});
				</script><?php 					
				
			}		
		}
	}
}
