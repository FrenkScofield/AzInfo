<?php

class Admin_haberModel extends AdminModel
{
	public $_tableName = 'haber';
	public $_primaryKey = 'haber_id';
	
	public $_gridTitle = 'Haberler';
	public $_itemTitle = 'Haber';
	public $_editFormClass = 'Admin_haberForm';
	
	public $_relations = array();
	
}
