<?php

class Admin_kurumsalModel extends AdminModel
{
	public $_tableName = 'kurumsal';
	public $_primaryKey = 'kurumsal_id';
	
	public $_gridTitle = 'Kurumsal';
	public $_itemTitle = 'Kurumsal';
	public $_editFormClass = 'Admin_kurumsalForm';
	
	public $_relations = array();
	
}
