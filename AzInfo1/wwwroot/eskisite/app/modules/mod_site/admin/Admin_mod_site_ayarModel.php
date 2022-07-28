<?php

class Admin_mod_site_ayarModel extends AdminModel
{
	public $_tableName = 'mod_site_ayar';
	public $_primaryKey = 'id';
	
	public $_relations = array();
	
	public $_gridTitle = 'Site Ayarları';
	public $_itemTitle = 'Site Ayarları';
	public $_editFormClass = 'Admin_mod_site_ayarForm';
}
