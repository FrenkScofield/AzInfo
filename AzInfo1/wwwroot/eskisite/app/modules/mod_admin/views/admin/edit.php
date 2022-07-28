<?php 
$mainConfig = _getAppData(null);
$mainConfig = $mainConfig['config']['main'];
$urlType = $mainConfig['urlType'];
	
$form->showErrors();

if($showForm){
	$formLegend = isset($id)?'Edit':'Add';
	$formLegend = _mlang($formLegend,'main','mod_admin');
	
	$actLabel = isset($id)?'Save':'Add';
	$actLabel = _mlang($actLabel,'main','mod_admin');
	
	//$form_params = array();
	$form_params = $this->rowFilter;
	
	// model parameter is only required for Admin class
	if($this->className=='Admin'){
		$form_params['model'] = $this->modelName ;
	}

	if(isset($id))
	{
		$form_params['id'] = $id;
	}

	$action = CUrlHelper::getModUrl($this->controller.'/edit',$form_params);

	?>
	<form class="editForm" id="<?=$form_id?>" method="POST" action="<?=$action?>">
	<div class="results"></div>
	
	<fieldset>
		<legend class="grid_title"><?=_mlang($this->adminModel->_itemTitle,'main',$this->_module)?> <?=$formLegend?></legend>
		<span class="close_button" onclick="if($(this).parents('.editForm_container').eq(0).length==1){$(this).parents('.editForm_container').eq(0).slideUp('slow');}else{closeCurrentTab();}">X</span>
		
		<?php $this->editFormToolbar();?>
		
		<table class="editTable">
			<?php if(isset($id)){ ?><tr><td>ID</td><td>:</td><td><b><?=$id?></b></td></tr><?php } ?>
			<?php 
			$fList = array();
			
			foreach($form->_fields as $name=>$f){
				if(isset($f['tabgroup']) && isset($f['tablabel'])){
					if(!isset($fList[$f['tabgroup']])){
						$fList[$f['tabgroup']] = array();
					}
					if(!isset( $fList[$f['tabgroup']][$f['tablabel']] )){
						$fList[$f['tabgroup']][$f['tablabel']] = array();
					}
					$fList[$f['tabgroup']][$f['tablabel']][] = $name;
				} else {
					$fList[] = $name;
				}
			}
			
			foreach($fList as $key=>$val){
				if(is_array($val)){ // use tabs
					$groupLabel = $key;
					$tabs = $val;
					?>
					<tr>
						<td valign="top"><?=$groupLabel?></td><td valign="top">:</td>
						<td valign="top">
							<div id="<?= ($tabid = uniqid('fieldTabs_')) ?>">
								<ul>
								<?php 
								$i = 0;
								foreach($tabs as $tabLabel=>$tabFkeys){
									$tabkey = sha1($tabLabel);
									?><li><a href="#<?=$tabid.'_'.$tabkey?>"><?=$tabLabel?></a></li><?php 
									$i++;
								}
								?>
								</ul>
								<?php 
								$i = 0;
								foreach($tabs as $tabLabel=>$tabFkeys){
									$tabkey = sha1($tabLabel);
									// Eğer sekmede birden fazla field varsa table yapısı ile isimleriyle göster yoksa sadece input göster
									if(count($tabFkeys)>1){
										?><div id="<?=$tabid.'_'.$tabkey?>"><?php 
											?><table><?php 
											foreach($tabFkeys as $i=>$fName){
												$field = $form->_fields[$fName]['_field'];
												?><tr><?php 
													?>
													<td>
														<?=$form->_fields[$fName]['label']?>
														<?= isset($field->rules['required'])?' (*)':'' ?><?php if(!empty($field->info)){?><div class="info"><?php echo $field->info; ?></div><?php }?>
													</td>
													<td>:</td>
													<td><?php 
														if($field->editable){
															$field->showInput();
														}
														else{
															echo $field->db2ui($field->value);
														}
													?></td><?php 
												?></tr><?php 	
											}
											?></table><?php 
										?></div><?php 
									}
									else {
										?><div id="<?=$tabid.'_'.$tabkey?>" style="margin-top:6px;">
											<?php 
											foreach($tabFkeys as $i=>$fName){ // döngü 1 kez çalışır (tek öğe var)
												$field = $form->_fields[$fName]['_field'];
												if($field->editable){
													$field->showInput();
												}
												else{
													echo $field->db2ui($field->value);
												}
											}
										?></div><?php 
									}
									
									$i++;
								}
								?>
							</div>
							<script type="text/javascript">
								$('#<?=$tabid?>').tabs();
							</script>
						</td>
					</tr>
					<?php 
				} else {
					$fName = $val;
					$form->_fields[$fName]['_field']->showInputTr();
				}
			}
			
			?>
			<tr>
				<td colspan="2"></td><td>
					<input type="submit" value="<?=$actLabel?>">
					<input type="reset" value="<?=_mlang('Reset','main','mod_admin')?>">
					<button onclick="var div =$(this).parents('.editForm_container').eq(0); if(div.length==1){div.slideUp('slow')}else{closeCurrentTab();};return false;"><?=_mlang('Close','main','mod_admin')?></button>
				</td>
			</tr>
		</table>
		<?php 
		// show subgrids
		if(isset($id) && isset($this->subgrids) && count($this->subgrids)>0)
		{
			?><div style="margin-top:10px;padding:15px 0 0 0;clear:both;border-top:1px dashed #000000;"><?php 
			foreach($this->subgrids as $rel=>$adminClass)
			{
				if(
					!(
					isset($this->adminModel->_relations[$rel])
					&& in_array($this->adminModel->_relations[$rel]['rel'],array('hasMany','hasOne'))
					)
				)
					continue;
				
				$relation = & $this->adminModel->_relations[$rel];
				
				$Admin = new $adminClass ();
				$Admin->_beforeAction('list');
				
				$Admin->createForm();
				
				if(!count($Admin->listCols)>0)
				{
					foreach($Admin->editForm->_fields as $name=>$f)
					{
						$Admin->listCols[] = $name;
					}
				}
				$Admin->refreshListCols();
				
				$filter = array(); 			
				if( isset($relation['ref']) && isset($relation['remote_ref'])){ // make custom filter array if current class parent_id is not primary key 
					$filter = array(
						'_'.$relation['remote_ref']=>$this->adminModel->{$relation['ref']}
					);
				}else {
					$filter = array(
						'_'.$relation['ref']=>$id
					);
				}

				$vdata = array(
					'grid_id'=>uniqid(),
					'form'=>& $Admin->editForm,
					'filter'=>$filter
				);
				?><div style="margin-bottom:20px;"><?=$Admin->render_partial('list',$vdata)?></div><?php 
			}
			?></div><?php 
		}
		?>
	</fieldset>
	</form>
	<script type="text/javascript">
	$(function(){
		$('#<?=$form_id?>').ajaxForm({
			url:'<?=$action?><?=$urlType=='parametric'?'&':'?'?>xhr&_token='+window.token,
			//target:$('#<?=$form_id?>_result'),
			//resetForm:<?=isset($id)?'false':'true'?>,
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


	


