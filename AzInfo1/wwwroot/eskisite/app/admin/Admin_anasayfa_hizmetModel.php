<?php

class Admin_anasayfa_hizmetModel extends AdminModel
{
	public $_tableName = 'anasayfa_hizmet';
	public $_primaryKey = 'anasayfa_hizmet_id';
	
	public $_gridTitle = 'Anasayfa hizmetler';
	public $_itemTitle = 'Anasayfa hizmet';
	public $_editFormClass = 'Admin_anasayfa_hizmetForm';
	
	public $_relations = array();
	
}
