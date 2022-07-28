<?php
class ReferansModel extends CModel
{
	public $_tableName = 'referans';
	public $_primaryKey = 'referans_id';
		
	public $_relations = array(
		'Kategori'=>array(
			'rel'=>'belongsTo',
			'ref'=>'kategori_id',
			'class'=>'Referans_kategoriModel',
		)
	);
}
