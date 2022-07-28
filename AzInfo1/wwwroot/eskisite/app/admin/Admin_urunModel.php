<?php

class Admin_urunModel extends AdminModel
{
	public $_tableName = 'urun';
	public $_primaryKey = 'urun_id';
	
	public $_gridTitle = 'Ürünler';
	public $_itemTitle = 'Ürün';
	public $_editFormClass = 'Admin_urunForm';
	
	public $_relations = array(
		'Kategori'=>array(
			'rel'=>'belongsTo',
			'ref'=>'kategori_id',
			'class'=>'Admin_urun_kategoriModel'
		)
	);
	
}
