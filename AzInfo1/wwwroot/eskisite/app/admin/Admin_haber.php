<?php

class Admin_haber extends Admin
{
	public $modelName = 'Admin_haber';
	
	public $sortCols = array(
		'1'=>'desc',
		'0'=>'desc'
	);
	
	public $allowInsert = TRUE;
	public $allowUpdate = TRUE;
	public $allowDelete = TRUE;
}
