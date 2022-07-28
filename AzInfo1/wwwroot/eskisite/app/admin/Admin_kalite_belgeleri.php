<?php 

class Admin_kalite_belgeleri extends Admin_belge {
	public $modelName = 'Admin_kalite_belgeleri';
	public $rowFilter = array(
		'bolum'=>'kalite_belgeleri',
	);
}
class Admin_kalite_belgeleriModel extends Admin_belgeModel
{
	public $_gridTitle = 'Kalite Belgeleri';
	public $_itemTitle = 'Kalite Belgesi';
	
	public $_rowFilter = array(
		'bolum'=>'kalite_belgeleri',
	);
	
	public $_editFormClass = 'Admin_kalite_belgeleriForm';
}
class Admin_kalite_belgeleriForm extends Admin_belgeForm{
	
}
