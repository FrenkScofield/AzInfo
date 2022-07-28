<?php

class Admin_hizmet extends Admin
{
	public $modelName = 'Admin_hizmet';
	
	public $sortCols = array(
		'1'=>'asc'
	);
	
	public $allowInsert = TRUE;
	public $allowUpdate = TRUE;
	public $allowDelete = TRUE;
	
	public $subgrids = array(
		'Galeri'=>'Admin_hizmet_galeri'
	);
}
