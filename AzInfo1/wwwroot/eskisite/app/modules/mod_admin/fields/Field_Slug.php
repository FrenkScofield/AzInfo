<?php

class Field_Slug extends CField
{
	public $unique = true;
	public $source = '';
	/*
	public function input2db($inputValue)
	{
		$return = '';
		if(is_array($inputValue))
		{
			$return = implode('|',$inputValue);
		}else {
			$return = $inputValue;
		}
		return $return;
	}
	*/
	
	public function showInput()
	{
		?>
		<input id="<?=$this->id?>" type="text" name="<?=$this->name?>" value="<?=$this->value?>" class="wide" />
		<?php 
		if(!empty($this->source)){
			?>
			<script type="text/javascript">
				$(function(){
					var $form = $('#<?=$this->id?>').parents('form').eq(0);
					var $srcField = $form.find('[name=<?=$this->source?>]');
					
					$srcField.change(function(){
						var str = $srcField.val();
						$.post(
							'<?=CUrlHelper::getModXUrl('mod_admin','fields/getSlug')?>',
							{'str':str},
							function(slug){
								$('#<?=$this->id?>').val(slug);
							}
						);
					});
					
				});
			</script>
			<?php 
		}
	}
	
}
