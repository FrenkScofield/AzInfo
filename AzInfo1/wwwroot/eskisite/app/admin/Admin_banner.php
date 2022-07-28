<?php

class Admin_banner extends Admin
{
	public $modelName = 'Admin_banner';
	
	public $sortCols = array(
		'1'=>'asc',
		'2'=>'asc'
	);
	
	public $allowInsert = TRUE;
	public $allowUpdate = TRUE;
	public $allowDelete = TRUE;
}
