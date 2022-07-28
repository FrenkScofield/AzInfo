<?php 
$form_id = uniqid();

$form->showErrors();

if($showForm){	
	$actLabel = _l('Edit');
	
	$action = CUrlHelper::getModUrl('user/settings');
	?>
	<form id="<?=$form_id?>" method="POST" action="<?=$action?>">
	<div class="results"></div>
	<fieldset>
		<legend class="grid_title"><?=_l('Settings')?></legend>
		<table>
			<tr><td><?=_l('Username')?></td><td>:</td><td><b><?=$_SESSION['mod_admin']['user']['username']?></b></td></tr>
			<tr><td><?=_l('Email')?></td><td>:</td><td><b><?=$_SESSION['mod_admin']['user']['email']?></b></td></tr>
			<?php 
			foreach($form->_fields as $name=>$f){
				$f['_field']->showInputTr();
			}
			?>
			<tr>
				<td colspan="2"></td><td>
					<input type="submit" name="submit" value="<?=$actLabel?>">					
				</td>
			</tr>
		</table>		
	</fieldset>
	</form>
	<script type="text/javascript">
	$(function(){
		$('#<?=$form_id?>').ajaxForm({
			url:'<?=$action?>?xhr',			
			resetForm:false,
			beforeSubmit: function(arr, $form, options) { 
				$('#loading').show();
			},
			success: function(responseText,statusText,xhr,$form){			
				$('#loading').hide();
				//notify(responseText);
				$('#<?=$form_id?> .results').html(responseText);
			}
		});
	});
	</script>
	<?php 
}


