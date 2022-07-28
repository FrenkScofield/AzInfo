<?php

class Admin_urun_kategori extends Admin
{
	public $modelName = 'Admin_urun_kategori';
	
	public $sortCols = array(
		'1'=>'asc'
	);
	
	public $allowInsert = TRUE;
	public $allowUpdate = TRUE;
	public $allowDelete = TRUE;
}
