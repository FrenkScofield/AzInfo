<?php

class Admin_referans_kategoriModel extends AdminModel
{
	public $_tableName = 'referans_kategori';
	public $_primaryKey = 'kategori_id';
	
	public $_gridTitle = 'Referans Kategoriler';
	public $_itemTitle = 'Referans kategori';
	public $_editFormClass = 'Admin_referans_kategoriForm';
	
	public $_relations = array();
	
	public function getLabel(){
		return $this->baslik;
	}
	
}
