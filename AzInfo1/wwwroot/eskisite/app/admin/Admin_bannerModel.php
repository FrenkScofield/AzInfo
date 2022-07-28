<?php

class Admin_bannerModel extends AdminModel
{
	public $_tableName = 'banner';
	public $_primaryKey = 'banner_id';
	
	public $_gridTitle = 'Banner';
	public $_itemTitle = 'Banner';
	public $_editFormClass = 'Admin_bannerForm';
	
	public $_relations = array();
	
}
