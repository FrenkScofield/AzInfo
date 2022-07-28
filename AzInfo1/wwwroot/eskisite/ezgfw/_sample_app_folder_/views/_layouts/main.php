<?php 
header('Content-type:text/html;charset=utf-8', true);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="<?php $desc = _getAppData('seo_description'); echo !empty($desc) ? $desc : (class_exists('ModSiteHelper') ? ModSiteHelper::get_ayar('aciklama_' . LANG) : '') ; ?>" />
		<meta name="keywords" content="<?php $words = _getAppData('seo_keywords'); echo !empty($words) ? $words : (class_exists('ModSiteHelper') ? ModSiteHelper::get_ayar('kelimeler_' . LANG) : '') ; ?>" />
		<title><?= $title ?></title>
	</head>
	<body>
		<div class="content"><?= $content ?></div>
	</body>
</html>

