<?php

class Field_Text extends CField
{
	public $counter = false;
	
	public function showInput()
	{
		?><input type="text" name="<?=$this->name?>" value="<?=$this->value?>" class="wide" <?=$this->getHtmlAttrs()?> <?php if($this->counter){ ?>onkeyup="$(this).next('.count').text( $(this).val().length );"<?php }?>> <?php if($this->counter){?><span class="count"></span><?php }
	}
}
