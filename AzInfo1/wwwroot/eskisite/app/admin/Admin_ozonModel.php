<?php

class Admin_ozonModel extends AdminModel
{
	public $_tableName = 'ozon';
	public $_primaryKey = 'ozon_id';
	
	public $_gridTitle = 'Ozon Sistemleri';
	public $_itemTitle = 'Ozon sistemi';
	public $_editFormClass = 'Admin_ozonForm';
	
	public $_relations = array();
	
}
