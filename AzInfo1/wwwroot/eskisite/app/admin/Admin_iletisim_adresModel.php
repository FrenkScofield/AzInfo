<?php

class Admin_iletisim_adresModel extends AdminModel
{
	public $_tableName = 'iletisim_adres';
	public $_primaryKey = 'adres_id';
	
	public $_gridTitle = 'İletişim Adresleri';
	public $_itemTitle = 'İletişim adresi';
	public $_editFormClass = 'Admin_iletisim_adresForm';
	
	public $_relations = array();
	
}
