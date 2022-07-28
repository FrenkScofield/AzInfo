<?php

class CField
{
	public $ownerForm=null; // parent form object of this field
	public $ownerModel=null; // parent model object of $this->ownerForm
	public $controllerName = ''; // to be able to specifiy custom controller name (useful for some field types)
	
	public $id = '';
	public $label='';
	public $info=''; // for additional comments/explanations about the field

	public $name='';
	public $value='';
	public $attrs=array();

	public $rules=array();

	public $defaultValue;
	public $allowHtml = false;
	public $editable = true;
	public $unique = false;

	// for fields having a related model
	public $related = '';


	public function __construct($params = array(),& $ownerForm=null,& $ownerModel=null)
	{
		$this->ownerForm = $ownerForm;
		$this->ownerModel = $ownerModel;

		//echo is_object($this->ownerModel) ? 'TRUE':'FALSE';

		foreach($params as $key=>$value)
		{
			if(isset($this->$key))
			{
				$this->$key = $value;
			}
		}
		$this->id = uniqid();
	}

	public function __toString()
	{
		$return = $this->db2ui();
		return is_string($return)?$return:'';
	}


	public function getValue()
	{
		return $this->value;
	}

	public function setValue($val)
	{
		$this->value = $val;
	}

	public function db2ui($dbValue=null)
	{
		if($dbValue===null) $dbValue = $this->value;
		return $dbValue;
	}

	public function input2db($inputValue)
	{
		return $inputValue;
	}

	public function showInputTr()
	{
		?><tr><td valign="top"><?=$this->label?><?= isset($this->rules['required'])?' (*)':'' ?><?php if(!empty($this->info)){?><div class="info"><?php echo $this->info; ?></div><?php }?></td><td valign="top">:</td><td valign="top"><?php 
			if($this->editable){
				$this->showInput();
			}
			else{
				echo $this->db2ui($this->value);
			}
		?></td></tr><?php 
	}

	public function showInput()
	{
		?><input id="<?=$this->id?>" type="text" name="<?=$this->name?>" value="<?=$this->db2input($this->value)?>" <?=$this->getHtmlAttrs()?>><?php 
	}
	
	public function getHtmlAttrs(){
		$return = array();
		foreach($this->attrs as $name=>$value){
			$return[] = $name.'="'.str_replace('"', '\"', $value).'" ';
		}
		return implode(' ',$return);
	}
	
}
