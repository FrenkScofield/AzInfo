<?php

class ModAdminUserModel extends AdminModel
{
	public $_tableName = 'mod_admin_user';
	public $_primaryKey = 'user_id';
	
	public $_relations = array(
		'Group'=>array(
			'rel'=>'belongsTo',
			'ref'=>'group_id',
			'class'=>'ModAdminUserGroupModel',
		)
	);
	
	public $_gridTitle = 'Admin Users';
	public $_itemTitle = 'Admin User';
	
	public $_editFormClass = 'ModAdminUserForm';
	
}
