<?php 
$onlyform = isset($_GET['onlyform']);

CCoreHelper::loadConfig('main');

if(!$onlyform){

?>
<div id="form_container" style="width:300px;">
<?php 
$action = CUrlHelper::getModUrl('user/login');
$form_id = uniqid();

?>
<form id="login_form_<?=$form_id?>" class="login_form" action="<?=$action?>" method="POST">
	<?php 	
}
	echo $form->getTokenInput();
	
	$form->showErrors();
	?>
	<table>
		<tr>
			<td><?=_l('Username')?> </td>
			<td><input type="text" name="user" value="<?=$form->user?>"></td>
		</tr>
		<tr>
			<td><?=_l('Password')?> </td>
			<td><input type="password" name="password"></td>
		</tr>
		<?php 
		$mod_params = CCoreHelper::getModXParams('mod_admin');
		$login_captcha = isset($mod_params['login_captcha'])?$mod_params['login_captcha']:true;
		
		if($login_captcha && !_getAppData('is_localhost')){
			?>
			<tr>
				<td><?=_l('Confirm code')?></td>
				<td><input type="text" name="captcha_code" value=""/> </td>
			</tr>
			<tr>
				<td colspan="2">
				<div>
					<img id="siimage" align="left" style="padding-right: 5px; border: 0" src="<?=ASSET_URL.'/secureimage/'?>securimage_show.php?sid=<?php echo md5(time()) ?>" />
					<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="19" height="19" id="SecurImage_as3" align="middle">
						<param name="allowScriptAccess" value="sameDomain" />
						<param name="allowFullScreen" value="false" />
						<param name="movie" value="<?=ASSET_URL.'/secureimage/'?>securimage_play.swf?audio=securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
						<param name="quality" value="high" />
					
						<param name="bgcolor" value="#ffffff" />
						<embed src="<?=ASSET_URL.'/secureimage/'?>securimage_play.swf?audio=<?=ASSET_URL.'/secureimage/'?>securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="19" height="19" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
					 </object>
					 <br />
					 <a tabindex="-1" style="border-style: none" href="#" title="Kod yenile" onclick="document.getElementById('siimage').src = '<?=ASSET_URL.'/secureimage/'?>securimage_show.php?sid=' + Math.random(); return false">
						<img src="<?=ASSET_URL.'/secureimage/'?>images/refresh.gif" alt="Kod yenile" border="0" onclick="this.blur()" align="bottom" />
					</a>
				</div>
				</td>
			</tr>
			<?php 
		}
		?>
		<tr>
			<td></td>
			<td colspan=""> <input type="submit" value="<?=_l('Login')?>"></td>
		</tr>		
	</table>
<?php 
if(!$onlyform){
?>
</form>
<script type="text/javascript">
$(function(){
	$('#login_form_<?=$form_id?>').submit(function(e){
		e.preventDefault();
		var data = 			
			'user=' + $(this).find('input[name=user]').val() +
			'&password=' + $(this).find('input[name=password]').val() +
			'&captcha_code=' + $(this).find('input[name=captcha_code]').val() +
			'&'+ $(this).find('input[type=hidden]').attr('name') +'=' + $(this).find('input[type=hidden]').val()
		;
		$.post('<?=$action?>?lock&onlyform',data,function(result){
			if(result=='ok'){
				$.unblockUI();
				blocked = false;
				$('#form_container').html('');
				refresh_admin_menu();
				ping();
			}
			else $('#form_container form').html(result);
		});
		return false;
	});	
});
</script>
</div>
<?php 
}
?>
