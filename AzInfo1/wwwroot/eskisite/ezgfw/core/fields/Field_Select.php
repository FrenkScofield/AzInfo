<?php

class Field_Select extends CField
{
	public $options = array();
	protected $_gotOptions = false;
		
	protected function getOptions()
	{
		$options = $this->options;
		if(!empty($this->related))
		{			
			$relClass = $this->ownerModel->_relations[$this->related]['class'];
			$relModel = new $relClass();
						
			$relModel->orderBy($relModel->_defaultOrderBy)->run();
			
			while($relModel->fetchRow()){				
				$options[ $relModel->getId() ] = $relModel->getLabel();
			}			
		}
		$this->options = $options;
		$this->_gotOptions = true;
	}
	
	public function db2ui($value=null)
	{
		if($value===null) $value = $this->value;
		
		if(!$this->_gotOptions)
		{
			$this->getOptions();
		}
		return isset($this->options[$value])?$this->options[$value] : $value;
	}
	
	public function showInput()
	{
		if(!$this->_gotOptions)
		{
			$this->getOptions();
		}		
		?><select name="<?=$this->name?>">
			<option value=""></option><?php 			
			foreach($this->options as $val=>$label)
			{
				?><option value="<?=$val?>" <?=$this->value==$val?'selected="selected"':''?>><?=$label?></option><?php 
			}			
			?>
		</select><?php 
	}
}
