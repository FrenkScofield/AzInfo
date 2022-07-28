<?php

class Admin_banner_mobilModel extends AdminModel
{
	public $_tableName = 'banner_mobil';
	public $_primaryKey = 'banner_id';
	
	public $_gridTitle = 'Mobil slider';
	public $_itemTitle = 'Mobil slider';
	public $_editFormClass = 'Admin_banner_mobilForm';
	
	public $_relations = array();
	
}
