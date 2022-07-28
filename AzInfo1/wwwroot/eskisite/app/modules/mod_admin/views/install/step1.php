<h3>Select modules to install:</h3>

<form method="POST" action="<?=CUrlHelper::getModUrl('install/step2')?>">
<?php foreach($modules as $m):
	$module = $m['module'];
	$alias = $m['alias'];
	?>
	<p>
		<input class="moduleselect" name="module_selected[<?=$module?>]" type="checkbox"> <?=$alias?> (<?=$module?>)
		<span class="moduleparams">
		<?php 
		if($module=='mod_admin')
		{
			?>
			username: <input name="mod_admin_username" type="text"> 
			password: <input name="mod_admin_password" type="password"> 
			password repeat: <input name="mod_admin_password2" type="password"> 			
			<?php 
		}
		?>
		</span>
	</p>
<?php endforeach;?>
<input type="submit" value="Install modules">
</form>

<style type="text/css">
.moduleparams {display:none;}
</style>

<script type="text/javascript">
$(function(){
	$('input.moduleselect').click(function(){
		var selected = $(this).is(':checked');
		var $params = $(this).next('.moduleparams');
		if(selected)
			$params.show();
		else
			$params.hide();			
	});
});
</script>
