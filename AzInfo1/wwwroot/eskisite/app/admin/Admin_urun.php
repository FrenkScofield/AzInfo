<?php

class Admin_urun extends Admin
{
	public $modelName = 'Admin_urun';
	
	public $sortCols = array(
		'1'=>'asc',
		'2'=>'asc'
	);
	
	public $allowInsert = TRUE;
	public $allowUpdate = TRUE;
	public $allowDelete = TRUE;
}
