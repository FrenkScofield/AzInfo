<?php 

class Admin_sistem_bilgi_formatlari extends Admin_belge {
	public $modelName = 'Admin_sistem_bilgi_formatlari';
	public $rowFilter = array(
		'bolum'=>'sistem_bilgi_formatlari',
	);
}
class Admin_sistem_bilgi_formatlariModel extends Admin_belgeModel
{
	public $_gridTitle = 'Sistem Bilgi Formatları';
	public $_itemTitle = 'Sistem bilgi formatı';
	
	public $_rowFilter = array(
		'bolum'=>'sistem_bilgi_formatlari',
	);
	
	public $_editFormClass = 'Admin_sistem_bilgi_formatlariForm';
}
class Admin_sistem_bilgi_formatlariForm extends Admin_belgeForm{
	
}
