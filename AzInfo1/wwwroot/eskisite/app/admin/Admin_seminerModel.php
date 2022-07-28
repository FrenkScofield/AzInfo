<?php

class Admin_seminerModel extends AdminModel
{
	public $_tableName = 'seminer';
	public $_primaryKey = 'seminer_id';
	
	public $_gridTitle = 'Seminerler';
	public $_itemTitle = 'Seminer';
	public $_editFormClass = 'Admin_seminerForm';
	
	public $_relations = array();
	
}
