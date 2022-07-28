<?php

class Admin_belge extends Admin
{
	public $modelName = 'Admin_belge';
	
	public $sortCols = array(
		'1'=>'asc'
	);
	
	public $allowInsert = TRUE;
	public $allowUpdate = TRUE;
	public $allowDelete = TRUE;
}
