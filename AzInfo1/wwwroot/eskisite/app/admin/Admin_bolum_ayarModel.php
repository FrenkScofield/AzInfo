<?php

class Admin_bolum_ayarModel extends AdminModel
{
	public $_tableName = 'bolum_ayar';
	public $_primaryKey = 'bolum_id';
	
	public $_gridTitle = 'Bölüm ayarları';
	public $_itemTitle = 'Bölüm ayarları';
	public $_editFormClass = 'Admin_bolum_ayarForm';
	
	public $_relations = array();
	
}
