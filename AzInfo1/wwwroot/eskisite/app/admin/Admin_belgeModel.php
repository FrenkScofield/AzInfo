<?php

class Admin_belgeModel extends AdminModel
{
	public $_tableName = 'belge';
	public $_primaryKey = 'belge_id';
	
	public $_gridTitle = 'Belgeler';
	public $_itemTitle = 'Belge';
	public $_editFormClass = 'Admin_belgeForm';
	
	public $_relations = array();
	
}
