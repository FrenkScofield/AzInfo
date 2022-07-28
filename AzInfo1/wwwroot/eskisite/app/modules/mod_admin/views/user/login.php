<!DOCTYPE HTML>
<html>
	<head>
		<title><?=_l('Login')?></title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="<?= ASSET_URL ?>/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="<?= ASSET_URL ?>/css/login.css" />
	</head>
	<?php 
	$mod_params = CCoreHelper::getModXParams('mod_admin');
	$login_captcha = isset($mod_params['login_captcha'])?$mod_params['login_captcha']:true;
	$kod_kullan = ($login_captcha && !_getAppData('is_localhost'));
	?>
	<body>
		<form class="box login" <?=$kod_kullan?'style="height:400px;margin:-200px 0 0 -166px;"':''?> action="<?= CUrlHelper::getModUrl('user/login') ?>" method="POST">
			<?=$form->getTokenInput();?>
			<fieldset class="boxBody">
				<label><?= _l('Username') ?></label>
				<input type="text" tabindex="1" name="user" value="<?= $form->user ?>" />
				<label><?php /*<a href="#" class="rLink" tabindex="5">Forget your password?</a>*/?><?= _l('Password') ?></label>
				<input type="password" tabindex="2" name="password" />
				<?php 
				if($kod_kullan){ ?>
				<label><?=_l('Confirm code')?></label>
				<div>
					<img id="siimage" align="left" style="padding-right: 5px; border: 0" src="<?=ASSET_URL.'/secureimage/'?>securimage_show.php?sid=<?php echo md5(time()) ?>" />
					<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="19" height="19" id="SecurImage_as3" align="middle">
						<param name="allowScriptAccess" value="sameDomain" />
						<param name="allowFullScreen" value="false" />
						<param name="movie" value="<?=ASSET_URL.'/secureimage/'?>securimage_play.swf?audio=securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
						<param name="quality" value="high" />

						<param name="bgcolor" value="#ffffff" />
						<embed src="<?=ASSET_URL.'/secureimage/'?>securimage_play.swf?audio=<?=ASSET_URL.'/secureimage/'?>securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="19" height="19" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
					</object><br />
					<a tabindex="-1" style="border-style: none" href="#" title="Kod yenile" onclick="document.getElementById('siimage').src = '<?=ASSET_URL.'/secureimage/'?>securimage_show.php?sid=' + Math.random(); return false"><img src="<?=ASSET_URL.'/secureimage/'?>images/refresh.gif" alt="Kod yenile" border="0" onclick="this.blur()" align="bottom" /></a>
				</div>
				<input type="text" tabindex="3" name="captcha_code" value=""/>
				<?php } ?>
			</fieldset>
			<footer>
				<?php /*<label><input type="checkbox" tabindex="3">Keep me logged in</label>*/?>
				<input type="submit" class="btnLogin" value="<?=_l('Login')?>" tabindex="4" />
			</footer>
		</form>
		<footer id="main"></footer>
		<?php 
		if($form->hasErrors()){
			$errors = implode('\n',$form->getErrors());
			?><script type="text/javascript">alert('<?=$errors?>');</script><?php 
		} 
		else if(isset($_SESSION['alert'])){
			?><script type="text/javascript">alert('<?=$_SESSION['alert']?>');</script><?php 
			unset($_SESSION['alert']);
		}
		?>
	</body>
</html>
