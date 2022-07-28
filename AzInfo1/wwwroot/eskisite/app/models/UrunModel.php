<?php
class UrunModel extends CModel
{
	public $_tableName = 'urun';
	public $_primaryKey = 'urun_id';
		
	public $_relations = array(
		'Kategori'=>array(
			'rel'=>'belongsTo',
			'ref'=>'kategori_id',
			'class'=>'Urun_kategoriModel'
		)
	);
}
