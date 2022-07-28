<?php

class ModAdminEmailTemplateModel extends AdminModel
{
	public $_tableName = 'mod_admin_email_template';
	public $_primaryKey = 'template_id';
	
	public $_relations = array(
	);
	
	public $_gridTitle = 'Templates';
	public $_itemTitle = 'Template';
	
	public $_editFormClass = 'ModAdminEmailTemplateForm';
	
}
