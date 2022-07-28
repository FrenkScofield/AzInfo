<?php 

class Admin_teknik_belgeler extends Admin_belge {
	public $modelName = 'Admin_teknik_belgeler';
	public $rowFilter = array(
		'bolum'=>'teknik_belgeler',
	);
}
class Admin_teknik_belgelerModel extends Admin_belgeModel
{
	public $_gridTitle = 'Teknik Belgeler';
	public $_itemTitle = 'Teknik Belge';
	
	public $_rowFilter = array(
		'bolum'=>'teknik_belgeler',
	);
	
	public $_editFormClass = 'Admin_teknik_belgelerForm';
}
class Admin_teknik_belgelerForm extends Admin_belgeForm{
	
}
