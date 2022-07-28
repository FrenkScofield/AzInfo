<?php

class Admin_referansModel extends AdminModel
{
	public $_tableName = 'referans';
	public $_primaryKey = 'referans_id';
	
	public $_gridTitle = 'Referanslar';
	public $_itemTitle = 'Referans';
	public $_editFormClass = 'Admin_referansForm';
	
	public $_relations = array(
		'Kategori'=>array(
			'rel'=>'belongsTo',
			'ref'=>'kategori_id',
			'class'=>'Admin_referans_kategoriModel',
		)
	);
	
}
