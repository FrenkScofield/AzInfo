<?php

class Admin_mod_popup_popupModel extends AdminModel
{
	public $_tableName = 'mod_popup_popup';
	public $_primaryKey = 'popup_id';
	
	public $_relations = array(
	);
	
	public $_gridTitle = 'Popup Duyurular';
	public $_itemTitle = 'Popup Duyuru';
	
	public $_editFormClass = 'Admin_mod_popup_popupForm';
}
