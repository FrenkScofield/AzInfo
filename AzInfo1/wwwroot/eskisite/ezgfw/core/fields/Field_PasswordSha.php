<?php

class Field_PasswordSha extends CField
{
	public function showInput()
	{
		?><input type="password" name="<?=$this->name?>"><?php 
	}
	
	public function db2ui($value=null)
	{		
		return '';
	}
	
	public function db2input($dbValue)
	{		
		return '';
	}
	
	public function input2db($inputValue)
	{
		return empty($inputValue)? false : sha1($inputValue);
	}
	
}
