<?php

class ModAdminUserGroupModel extends AdminModel
{
	public $_tableName = 'mod_admin_user_group';
	public $_primaryKey = 'group_id';
	
	public $_relations = array(
		
	);	
	
	public $_gridTitle = 'Admin User Groups';
	public $_itemTitle = 'Admin User Group';
	
	public $_editFormClass = 'ModAdminUserGroupForm';
	
	public function getLabel()
	{
		return $this->name;
	}
	
}
