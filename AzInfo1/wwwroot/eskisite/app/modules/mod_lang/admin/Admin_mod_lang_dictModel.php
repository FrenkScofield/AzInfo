<?php

class Admin_mod_lang_dictModel extends AdminModel
{
	public $_tableName = 'mod_lang_dict';
	public $_primaryKey = 'word_id';
	
	public $_relations = array(
	);
	
	//public $_gridTitle = 'Dictionary';
	public $_gridTitle = 'Sözlük';
	//public $_itemTitle = 'Word';
	public $_itemTitle = 'Sözcük';
	
	public $_editFormClass = 'Admin_mod_lang_dictForm';
	
}
