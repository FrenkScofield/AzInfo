<?php 
$form->showErrors();
?>
<div class="results"></div>
<fieldset style="margin-bottom:10px;">
	<legend class="grid_title"><?=_mlang($this->adminModel->_itemTitle,'main',$this->_module)?></legend>
	<span class="close_button" onclick="if($(this).parents('.editForm_container').eq(0).length==1){$(this).parents('.editForm_container').eq(0).slideUp('slow');}else{closeCurrentTab();}">X</span>
	
	<?php $this->showToolbar($id);?>
	
	<table>		
		<?php 
		foreach($form->_fields as $name=>$f){
			?><tr><td><?=$f['_field']->label?></td><td>:</td><td><?=$f['_field']?></td></tr><?php 			
		}
		?>
		<tr>
			<td colspan="2"></td><td>
				<button onclick="if($(this).parents('.editForm_container').eq(0).length==1){$(this).parents('.editForm_container').eq(0).slideUp('slow');}else{closeCurrentTab();}"><?=_mlang('Close','main','mod_admin')?></button>
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
	
	
	



