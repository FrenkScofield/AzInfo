<?php

class Admin_mod_admin_user_group extends Admin
{
	public $modelName = 'ModAdminUserGroup';
	
	public $listCols = array('group_id','name');
	
	public function actionEdit($row_id = null, $skipRequireAllow = false) {
		parent::actionEdit($row_id);
		?><script type="text/javascript">refresh_admin_menu();</script><?php 
	}
}
