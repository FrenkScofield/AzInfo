<?php

class Field_Hidden extends CField
{
	public function showInput()
	{
		?><input type="hidden" name="<?=$this->name?>" value="<?=$this->value?>"><?php 
	}
	
	public function showInputTr()
	{
		?><tr style="display:none;"><td></td><td></td><td><?php $this->showInput() ?></td></tr><?php 
	}
}
