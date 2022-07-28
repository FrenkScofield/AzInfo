<?php

class Admin_urun_kategoriModel extends AdminModel
{
	public $_tableName = 'urun_kategori';
	public $_primaryKey = 'kategori_id';
	
	public $_gridTitle = 'Ürün Kategoriler';
	public $_itemTitle = 'Ürün kategori';
	public $_editFormClass = 'Admin_urun_kategoriForm';
	
	public $_relations = array();
	
	public function getLabel()
	{
		return $this->baslik;
	}
	
}
