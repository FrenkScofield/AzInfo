<?php

class Admin_mod_url_urlModel extends AdminModel
{
	public $_tableName = 'mod_url_url';
	public $_primaryKey = 'url_id';
	
	public $_gridTitle = 'Sayfa Ayarları';
	public $_itemTitle = 'Sayfa Ayarları';
	public $_editFormClass = 'Admin_mod_url_urlForm';
	
	public $_relations = array();
	
}
