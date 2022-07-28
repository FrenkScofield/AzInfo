<?php

class Admin_nsfModel extends AdminModel
{
	public $_tableName = 'nsf';
	public $_primaryKey = 'nsf_id';
	
	public $_gridTitle = 'NSF\'li Ürünler';
	public $_itemTitle = 'NSF\'li ürün';
	public $_editFormClass = 'Admin_nsfForm';
	
	public $_relations = array();
	
}
