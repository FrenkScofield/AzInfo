<?php

class Field_Password extends CField
{
	public function showInput()
	{
		?><input type="password" name="<?=$this->name?>" value="<?=$this->value?>"><?php 
	}
	
	public function db2input()
	{
		return '';
	}
	
}
