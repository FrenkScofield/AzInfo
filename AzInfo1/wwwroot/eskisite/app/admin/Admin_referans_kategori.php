<?php

class Admin_referans_kategori extends Admin
{
	public $modelName = 'Admin_referans_kategori';
	
	public $sortCols = array(
		'1'=>'asc'
	);
	
	public $allowInsert = TRUE;
	public $allowUpdate = TRUE;
	public $allowDelete = TRUE;
}
