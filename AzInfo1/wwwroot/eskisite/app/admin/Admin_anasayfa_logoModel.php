<?php

class Admin_anasayfa_logoModel extends AdminModel
{
	public $_tableName = 'anasayfa_logo';
	public $_primaryKey = 'anasayfa_logo_id';
	
	public $_gridTitle = 'Anasayfa Logolar';
	public $_itemTitle = 'Anasayfa logo';
	public $_editFormClass = 'Admin_anasayfa_logoForm';
	
	public $_relations = array();
	
}
