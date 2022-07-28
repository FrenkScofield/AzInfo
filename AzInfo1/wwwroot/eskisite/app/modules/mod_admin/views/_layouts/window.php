<?php 
header('Content-type:text/html;charset=utf-8',true);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title?></title>

<link href="<?=ASSET_URL?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?=ASSET_URL?>/css/ui/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?=ASSET_URL?>/js/jnotify/jquery.jnotify.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?=ASSET_URL?>/js/js.php"></script>
</head>

<body style="background:#FFFFFF;padding:10px;">

<div class="loading"><img src="<?=ASSET_URL.'/images/'?>ajax-loader.gif"></div>

<?=$content?>

<div class="loading" style="margin-top:10px;"><img src="<?=ASSET_URL.'/images/'?>ajax-loader.gif"></div>


<script type="text/javascript">
$(function(){ 
	setInterval(function(){
		$('.loading').hide();
	},500);	
});
</script>
</body>
</html>
