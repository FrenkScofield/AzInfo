<?php

class Field_Checkbox extends CField
{
	public $label_active='';
	
	public function showInput()
	{
		?><input type="checkbox" name="<?=$this->name?>" <?=$this->value=='1'?'CHECKED':''?>><?php 
	}
	
	public function db2ui($val=null)
	{
		if($val===null)
		{
			$val = $this->value;
		}
		$label_active = $this->label_active;
		if(empty($label_active)){
			$label_active = 'X';
		}
		return ($val=='1'?$label_active:'');
	}
	
	public function input2db($inputValue)
	{
		if(isset($_REQUEST[$this->name])){
			return 1;
		}else {
			return 0;
		}
	}
}
