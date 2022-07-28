<?php

class Field_Textarea extends CField
{
	public $counter = false;
	
	public function showInput()
	{
		?><textarea name="<?=$this->name?>" class="wide high" <?=$this->getHtmlAttrs()?> <?php if($this->counter){ ?>onkeyup="$(this).next('.count').text( $(this).val().length );"<?php }?>><?=$this->value?></textarea> <?php if($this->counter){?><span class="count"></span><?php }
	}
	
	public function db2ui($dbValue=null){
		if($dbValue===null) $dbValue = $this->value;
		return nl2br($dbValue);
	}
}
