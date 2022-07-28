<?php

class Admin_seminerlerModel extends AdminModel
{
	public $_tableName = 'seminerler';
	public $_primaryKey = 'seminerler_id';
	
	public $_gridTitle = 'Seminerler';
	public $_itemTitle = 'Seminerler';
	public $_editFormClass = 'Admin_seminerlerForm';
	
	public $_relations = array();
	
}
