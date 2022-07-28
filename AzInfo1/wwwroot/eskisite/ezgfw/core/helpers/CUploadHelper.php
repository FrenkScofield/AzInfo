<?php

class CUploadHelper extends CHelper {

	public static function uploadFile($params) {
		$defaults = array(
			'input_name' => null,
			'input_file' => '',
			'file_path' => MEDIA_PATH . '/',
			'keep_original_name' => true,
		);

		$params = array_merge($defaults, $params);

		foreach ($params as $name => $value)
			$$name = $value;

		// File upload
		if (!empty($input_name)) {
			if (isset($_FILES[$input_name]))
				$handle = new Plugin_Upload($_FILES[$input_name]);
			//else trigger_error('$_FILES[' . $input_name . '] not found! $_FILES: ' . print_r($_FILES, true));
			else 
				return false;
		}
		else { // use existing file
			$handle = new Plugin_Upload($input_file);
		}

		if ($handle->uploaded) {
			if (!$keep_original_name) {
				$fnameBody = uniqid();
				$handle->file_new_name_body = $fnameBody;
			}

			// upload image before any resize operation
			$handle->process($file_path);

			if (!$handle->processed) {
				return false;
			}
			$fileNameBody = $handle->file_dst_name_body; //uploaded filename (without extension)
			$fileName = $handle->file_dst_name;

			return $fileName;
		} else {
			return false;
		}
	}

	public static function uploadImage($params) {

		$defaults = array(
			'input_name' => null,
			'input_file' => '',
			'img_path' => MEDIA_PATH . '/',
			'img_target_path' => false,
			'size_options' => array(
			//array('prefix'=>'k_','x'=>400,'y'=>300,'ratio_crop'=>false,'ratio_fill'=>true) // sample image size options array
			),
			'empty_original' => false,
			'keep_original_name' => true,
			'original_max_width' => 0,
			'original_max_height' => 0,
		);

		$params = array_merge($defaults, $params);

		foreach ($params as $name => $value)
			$$name = $value;

		if ($img_target_path === false) {
			$img_target_path = $img_path;
		}

		$uploaded_files = array(); // keep uploaded files list to delete all if upload process fails
		// Image upload
		if (!empty($input_name)) {
			if (isset($_FILES[$input_name]))
				$handle = new Plugin_Upload($_FILES[$input_name]);
			else
				trigger_error('$_FILES[' . $input_name . '] not found! $_FILES: ' . print_r($_FILES, true));
		}
		else { // use existing file
			$handle = new Plugin_Upload($input_file);
		}

		$handle->allowed = array("image/*"); //allow image files only		

		if ($handle->uploaded) {
			if (!$keep_original_name) {
				$fnameBody = uniqid();
				$handle->file_new_name_body = $fnameBody;
			}


			$resize_original = false;

			if ($params['original_max_width'] > 0) {
				$handle->image_x = $params['original_max_width'];
				$resize_original = true;
			}
			if ($params['original_max_height'] > 0) {
				$handle->image_y = $params['original_max_height'];
				$resize_original = true;
			}

			if ($resize_original) {
				$handle->image_resize = true;
				$handle->image_ratio = true;
				$handle->image_ratio_crop = false;
				$handle->image_ratio_no_zoom_in = true;
			}

			// upload image
			$handle->process($img_target_path);

			if (!$handle->processed) {
				return false;
			}
			$fileNameBody = $handle->file_dst_name_body; //uploaded filename (without extension)
			$fileName = $handle->file_dst_name;

			$original_image_path = $img_target_path . $fileName;

			$uploaded_files[] = $original_image_path;

			// resized images will be overwritten if exists			
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;

			foreach ($size_options as $opt) {
				$handle->init(); // sets default options
				$handle->image_resize = true;
				$handle->image_ratio_no_zoom_in = true;
				$handle->file_new_name_body = $opt['prefix'] . $fileNameBody;
				unset($opt['prefix']);

				foreach ($opt as $prop => $value) { // set resized image properties
					$name = 'image_' . $prop;
					$handle->$name = $value;
				}

				$handle->process($img_target_path);
				if (!$handle->processed) {
					foreach ($uploaded_files as $path) {
						@unlink($path);
					}
					return false;
				}
				$uploaded_files[] = $img_target_path . $handle->file_new_name_body . $handle->file_src_name_ext;
			}

			if ($empty_original) {
				@unlink($original_image_path);
				@file_put_contents($original_image_path, '');
			}

			return $fileName;
		} else {
			return false;
		}
	}

	public static function getMimeType($filename) {

		$ext = explode('.', $filename);
		$ext = end($ext);

		switch ($ext) {
			case 'jpg':
			case 'jpeg':
			case 'jpe':
				return 'image/jpeg';
				break;
			case 'gif':
				return 'image/gif';
				break;
			case 'png':
				return 'image/png';
				break;
			case 'bmp':
				return 'image/bmp';
				break;
			case 'flv':
				return 'video/x-flv';
				break;
			case 'js' :
				return 'application/x-javascript';
				break;
			case 'json' :
				return 'application/json';
				break;
			case 'tiff' :
				return 'image/tiff';
				break;
			case 'css' :
				return 'text/css';
				break;
			case 'xml' :
				return 'application/xml';
				break;
			case 'doc' :
			case 'docx' :
				return 'application/msword';
				break;
			case 'xls' :
			case 'xlt' :
			case 'xlm' :
			case 'xld' :
			case 'xla' :
			case 'xlc' :
			case 'xlw' :
			case 'xll' :
				return 'application/vnd.ms-excel';
				break;
			case 'ppt' :
			case 'pps' :
				return 'application/vnd.ms-powerpoint';
				break;
			case 'rtf' :
				return 'application/rtf';
				break;
			case 'pdf' :
				return 'application/pdf';
				break;
			case 'html' :
			case 'htm' :
			case 'php' :
				return 'text/html';
				break;
			case 'txt' :
				return 'text/plain';
				break;
			case 'mpeg' :
			case 'mpg' :
			case 'mpe' :
				return 'video/mpeg';
				break;
			case 'mp3' :
				return 'audio/mpeg3';
				break;
			case 'wav' :
				return 'audio/wav';
				break;
			case 'aiff' :
			case 'aif' :
				return 'audio/aiff';
				break;
			case 'avi' :
				return 'video/msvideo';
				break;
			case 'wmv' :
				return 'video/x-ms-wmv';
				break;
			case 'mov' :
				return 'video/quicktime';
				break;
			case 'zip' :
				return 'application/zip';
				break;
			case 'tar' :
				return 'application/x-tar';
				break;
			case 'swf' :
				return 'application/x-shockwave-flash';
				break;
			case 'odt':
				return 'application/vnd.oasis.opendocument.text';
				break;
			case 'ott':
				return 'application/vnd.oasis.opendocument.text-template';
				break;
			case 'oth':
				return 'application/vnd.oasis.opendocument.text-web';
				break;
			case 'odm':
				return 'application/vnd.oasis.opendocument.text-master';
				break;
			case 'odg':
				return 'application/vnd.oasis.opendocument.graphics';
				break;
			case 'otg':
				return 'application/vnd.oasis.opendocument.graphics-template';
				break;
			case 'odp':
				return 'application/vnd.oasis.opendocument.presentation';
				break;
			case 'otp':
				return 'application/vnd.oasis.opendocument.presentation-template';
				break;
			case 'ods':
				return 'application/vnd.oasis.opendocument.spreadsheet';
				break;
			case 'ots':
				return 'application/vnd.oasis.opendocument.spreadsheet-template';
				break;
			case 'odc':
				return 'application/vnd.oasis.opendocument.chart';
				break;
			case 'odf':
				return 'application/vnd.oasis.opendocument.formula';
				break;
			case 'odb':
				return 'application/vnd.oasis.opendocument.database';
				break;
			case 'odi':
				return 'application/vnd.oasis.opendocument.image';
				break;
			case 'oxt':
				return 'application/vnd.openofficeorg.extension';
				break;
			case 'docx':
				return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
				break;
			case 'docm':
				return 'application/vnd.ms-word.document.macroEnabled.12';
				break;
			case 'dotx':
				return 'application/vnd.openxmlformats-officedocument.wordprocessingml.template';
				break;
			case 'dotm':
				return 'application/vnd.ms-word.template.macroEnabled.12';
				break;
			case 'xlsx':
				return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
				break;
			case 'xlsm':
				return 'application/vnd.ms-excel.sheet.macroEnabled.12';
				break;
			case 'xltx':
				return 'application/vnd.openxmlformats-officedocument.spreadsheetml.template';
				break;
			case 'xltm':
				return 'application/vnd.ms-excel.template.macroEnabled.12';
				break;
			case 'xlsb':
				return 'application/vnd.ms-excel.sheet.binary.macroEnabled.12';
				break;
			case 'xlam':
				return 'application/vnd.ms-excel.addin.macroEnabled.12';
				break;
			case 'pptx':
				return 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
				break;
			case 'pptm':
				return 'application/vnd.ms-powerpoint.presentation.macroEnabled.12';
				break;
			case 'ppsx':
				return 'application/vnd.openxmlformats-officedocument.presentationml.slideshow';
				break;
			case 'ppsm':
				return 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12';
				break;
			case 'potx':
				return 'application/vnd.openxmlformats-officedocument.presentationml.template';
				break;
			case 'potm':
				return 'application/vnd.ms-powerpoint.template.macroEnabled.12';
				break;
			case 'ppam':
				return 'application/vnd.ms-powerpoint.addin.macroEnabled.12';
				break;
			case 'sldx':
				return 'application/vnd.openxmlformats-officedocument.presentationml.slide';
				break;
			case 'sldm':
				return 'application/vnd.ms-powerpoint.slide.macroEnabled.12';
				break;
			case 'thmx':
				return 'application/vnd.ms-officetheme';
				break;
			case 'onetoc':
			case 'onetoc2':
			case 'onetmp':
			case 'onepkg':
				return 'application/onenote';
				break;

			default:
				return 'application/octet-stream';
		}
	}
	
	public static function getFileSize($bytes)
	{
		if(is_file($bytes)){
			$bytes = filesize($bytes);
		}
		
		if ($bytes >= 1073741824)
		{
			$bytes = number_format($bytes / 1073741824, 2) . ' Gb';
		}
		elseif ($bytes >= 1048576)
		{
			$bytes = number_format($bytes / 1048576, 2) . ' Mb';
		}
		elseif ($bytes >= 1024)
		{
			$bytes = number_format($bytes / 1024, 2) . ' Kb';
		}
		elseif ($bytes > 1)
		{
			//$bytes = $bytes . ' bytes';
			$bytes = $bytes . ' b';
		}
		elseif ($bytes == 1)
		{
			//$bytes = $bytes . ' byte';
			$bytes = $bytes . ' b';
		}
		else
		{
			//$bytes = '0 bytes';
			$bytes = '0b';
		}
		return $bytes;
	}
	
	public static function removeDir($dir){
		$it = new RecursiveDirectoryIterator($dir);
		$files = new RecursiveIteratorIterator($it,  RecursiveIteratorIterator::CHILD_FIRST);
		foreach($files as $file) {
			if ($file->getFilename() === '.' || $file->getFilename() === '..') {
				continue;
			}
			if ($file->isDir()){
				rmdir($file->getRealPath());
			} else {
				unlink($file->getRealPath());
			}
		}
		rmdir($dir);		
	}

}
