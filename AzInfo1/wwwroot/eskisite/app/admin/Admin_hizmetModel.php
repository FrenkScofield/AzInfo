<?php

class Admin_hizmetModel extends AdminModel
{
	public $_tableName = 'hizmet';
	public $_primaryKey = 'hizmet_id';
	
	public $_gridTitle = 'Hizmetler';
	public $_itemTitle = 'Hizmet';
	public $_editFormClass = 'Admin_hizmetForm';
	
	public $_relations = array(
		'Galeri'=>array(
			'rel'=>'hasMany',
			'ref'=>'hizmet_id',
			'class'=>'Admin_hizmet_galeriModel'
		)
	);
	
	public function getLabel(){
		return $this->baslik;
	}
	
}
