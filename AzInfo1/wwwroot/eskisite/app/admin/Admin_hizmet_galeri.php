<?php

class Admin_hizmet_galeri extends Admin
{
	public $modelName = 'Admin_hizmet_galeri';
	
	public $sortCols = array(
		'2'=>'asc'
	);
	
	public $allowInsert = TRUE;
	public $allowUpdate = TRUE;
	public $allowDelete = TRUE;
}
