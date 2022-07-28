<?php

class Field_Images extends Field_Files
{
	public $file_type = 'image';
	public $size_options = array();
	public $original_max_width = 1500;
	public $original_max_height = 1500;
	public $show_thumbs = true;
}
