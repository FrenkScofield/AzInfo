<?php

class AdminModel extends CModel
{
	public $_gridTitle = 'Records';
	public $_itemTitle = 'Record';
	
	public $_editFormClass = 'CForm';
	
	public $_modelName = '';
	
	public $_rowFilter = array();
		
	public function getLabel()
	{
		return 'id:'. $this->getId();
	}			
}
