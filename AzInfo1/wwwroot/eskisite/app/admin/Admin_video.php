<?php

class Admin_video extends Admin
{
	public $modelName = 'Admin_video';
	
	public $sortCols = array(
		'1'=>'asc',
		'2'=>'asc'
	);
	
	public $allowInsert = TRUE;
	public $allowUpdate = TRUE;
	public $allowDelete = TRUE;
}
