<?php

class Admin_ikModel extends AdminModel
{
	public $_tableName = 'ik';
	public $_primaryKey = 'ik_id';
	
	public $_gridTitle = 'İnsan Kaynakları';
	public $_itemTitle = 'İnsan Kaynakları';
	public $_editFormClass = 'Admin_ikForm';
	
	public $_relations = array();
	
}
