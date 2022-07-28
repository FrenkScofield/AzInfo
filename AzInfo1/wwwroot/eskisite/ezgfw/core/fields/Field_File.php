<?php

class Field_File extends CField
{
	public function showInput()
	{
		?><input type="file" name="<?=$this->name?>" value="<?=$this->value?>"><?php 
	}
}
