<?php

class Admin_anasayfa_referansModel extends AdminModel
{
	public $_tableName = 'anasayfa_referans';
	public $_primaryKey = 'anasayfa_referans_id';
	
	public $_gridTitle = 'Anasayfa referanslar';
	public $_itemTitle = 'Anasayfa referans';
	public $_editFormClass = 'Admin_anasayfa_referansForm';
	
	public $_relations = array();
	
}
