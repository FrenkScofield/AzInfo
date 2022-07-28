<?php

class Admin_seminer extends Admin
{
	public $modelName = 'Admin_seminer';
	
	public $sortCols = array(
		'1'=>'asc'
	);
	
	public $allowInsert = TRUE;
	public $allowUpdate = TRUE;
	public $allowDelete = TRUE;
}
