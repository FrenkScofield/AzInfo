<?php

class Admin_hizmet_galeriModel extends AdminModel
{
	public $_tableName = 'hizmet_galeri';
	public $_primaryKey = 'hizmet_galeri_id';
	
	public $_gridTitle = 'Hizmet galeri';
	public $_itemTitle = 'Hizmet galeri';
	public $_editFormClass = 'Admin_hizmet_galeriForm';
	
	public $_relations = array(
		'Hizmet'=>array(
			'rel'=>'belongsTo',
			'ref'=>'hizmet_id',
			'class'=>'Admin_hizmetModel'
		)
	);
	
}
