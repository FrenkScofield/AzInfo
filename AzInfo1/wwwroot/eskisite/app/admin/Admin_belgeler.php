<?php 

class Admin_belgeler extends Admin_belge {
	public $modelName = 'Admin_belgeler';
	public $rowFilter = array(
		'bolum'=>'belgeler',
	);
}
class Admin_belgelerModel extends Admin_belgeModel
{
	public $_gridTitle = 'Belgeler';
	public $_itemTitle = 'Belge';
	
	public $_rowFilter = array(
		'bolum'=>'belgeler',
	);
	
	public $_editFormClass = 'Admin_belgelerForm';
}
class Admin_belgelerForm extends Admin_belgeForm{
	
}
