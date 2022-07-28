<?php

class Field_Radio extends Field_Select
{
	public function showInput()
	{
		if(!$this->_gotOptions)
		{
			$this->getOptions();
		}		
		
		foreach($this->options as $val=>$label)
		{
			?><input type="radio" name="<?=$this->name?>" value="<?=$val?>" <?=$this->value==$val?'checked="checked"':''?> /> <?=$label?><?php 
		}
		
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
								$('#<?=$this->id?> [value="<?=$this->value?>"]').attr('checked','checked');
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
