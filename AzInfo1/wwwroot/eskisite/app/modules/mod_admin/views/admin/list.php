<?php 
//echo '<pre>'. print_r($cols,true).'</pre>';

$url_params = array();
// model parameter is only required for Admin class
if($this->className=='Admin'){
	$url_params['model'] = $this->modelName ;
}

$edit_url_params = $url_params;

$ajax_url_params = $url_params;
if(isset($filter))
{
	foreach($filter as $col=>$val)
	{
		$val = urldecode($val);
		if(strpos($col, '_')===0){
			$ajax_url_params[$col] = $val;
			$edit_url_params[$col] = $val;
		}else {
			$ajax_url_params['_'.$col] = $val;
			$edit_url_params['_'.$col] = $val;
		}
	}
}
$ajax_url_params['ajax_grid'] = '1';
$ajax_url = CUrlHelper::getModUrl($this->controller.'/list',$ajax_url_params);
   
?>
<div class="list_container">

	<div class="editForm_container"></div>	

	<div class="result"></div>


	<div class="grid_container">
		<fieldset class="grid_fs">
			<legend class="grid_title"><?=_mlang($this->adminModel->_gridTitle,'main',$this->_module)?></legend>
			<br />
			<div class="grid_menu ui-widget icon-collection">
				<span class="ui-state-default ui-corner-all"><a class="grid_yenile"><?=_mlang('Refresh','main','mod_admin')?></a></span>
				<?php if($this->allowInsert){?><span class="ui-state-default ui-corner-all"><a class="xhr grid_satir_ekle" href="<?=CUrlHelper::getModUrl($this->controller.'/edit',$edit_url_params)?>"><?=_mlang('Add','main','mod_admin')?></a></span><?php }?>
				<span class="ui-state-default ui-corner-all"><a class="grid_arama"><?=_mlang('Search','main','mod_admin')?></a></span>
				<span class="ui-state-default ui-corner-all"><a class="grid_export_xls"><?=_mlang('Export (xls)','main','mod_admin')?></a></span>
			</div>

			<div class="arama" id="search_<?=$grid_id?>">
				<fieldset><legend class="grid_title"><?=_mlang('Search','main','mod_admin')?></legend>
					<table class="search_cols">
						<?php 
						foreach($form->_fields as $name=>$f)
						{
							if(!in_array($name,$this->listCols))
							{
								continue;
							}
							?><tr><td><?=$f['label']?></td><td><?php 
							switch($f['type']){
								case 'date':
								case 'timestamp':
									?>
									<input class="search_date range" type="text" size="9" />-<input class="search_date range" type="text" size="9" />
									<input type="hidden" class="filter_input" />
									<?php 
									break;
								default:
									?><input class="filter_input" type="text" style="width:85%;" /><?php 
							}							
							?>
							</td></tr><?php 
						}
						?>
						<tr><td></td><td>
							<button class="grid_filter"><?=_mlang('Search','main','mod_admin')?></button>
							<button onclick="$(this).parents('.arama').eq(0).slideUp('slow');return false;"><?=_mlang('Close','main','mod_admin')?></button>
						</td></tr>
					</table>
					<script type="text/javascript">
					$(function(){
						$('#search_<?=$grid_id?> .search_cols .search_date').mask('99.99.9999').datepicker();
						$('#search_<?=$grid_id?> .search_cols .range').change(function(){
							var td = $(this).parents('td').eq(0);
							var filter_input = td.find('.filter_input');
							var data = [];
							td.find('.range').each(function(){
								var val = $(this).val();
								if(val!=''){
									data[data.length]= val;
								}
							});
							filter_input.val(data.join('|'));
						});
					});
					</script>
				</fieldset>
			</div>
			
			
			<table id="<?=$grid_id?>" class="grid_table">
				<thead>
					<tr>
						<?php 
						$col_tables = array();

						foreach($form->_fields as $name=>$f)
						{
							if(!in_array($name,$this->listCols))
							{
								continue;
							}
							?><th><?=$f['label']?></th><?php 
							if(isset($f['related'])){
								$col_tables[$name] = $this->adminModel->{$f['related']}->_tableName;
							}
							else{
								$col_tables[$name] = $this->adminModel->_tableName;
							}
						}
						?>
						<th></th>
					</tr>			
				</thead>			
				<tbody id="<?=$grid_id?>_body"></tbody>
			</table>
		</fieldset>

		<script type="text/javascript">
		var grid_<?=$grid_id?> = {};
		
		var dtOptions = {
			"oLanguage": {
				"sSearch":"<?=_mlang('Search','main','mod_admin')?>",
				"sLengthMenu": "<?=_mlang('Show _MENU_ records per page','main','mod_admin')?>",
				"sZeroRecords": "<?=_mlang('No records found','main','mod_admin')?>",
				"sInfo": "<?=_mlang('Showing rows _START_ - _END_ of _TOTAL_ total rows','main','mod_admin')?>",
				"sInfoEmpty": "<?=_mlang('No records found','main','mod_admin')?>",
				"sInfoFiltered": "<?=_mlang('(Searched in _MAX_ rows)','main','mod_admin')?>"
			},			
			"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
				return nRow;
			},
			"bJQueryUI": true,
			//"sDom":'<"H"lr>t<"F"ip>',
			sDom: '<"dt-search-box"r><"H"lf>t<"F"ip>',
			"bProcessing": false,
			"bPaginate": true,
			//"sPaginationType": "full_numbers",
			"bLengthChange": true,
			"bFilter": true,
			"oSearch": {},
			"bSort": true,
			"bInfo": true,
			"bAutoWidth": false,
			"iDisplayLength": 50,
			"aLengthMenu": [10,25,50,100,250,500,1000],
			<?php 
			if(count($this->sortCols)>0){
				$sort_parts = array();
				foreach($this->sortCols as $col_i=>$direction){
					$sort_parts[] = array($col_i,$direction);
				}
				?>"aaSorting": <?= json_encode($sort_parts) ?>,<?php 
			}
			?>
			"bServerSide": true,
			"sAjaxSource": "<?=$ajax_url?>",
			"fnPreDrawCallback": function(oSettings) {$('.loading').show();},
			"fnDrawCallback": function( ) {$('.loading').hide();}
		};
		
		function grid_yenile_<?=$grid_id?>(){
			var oSettings = grid_<?=$grid_id?>.fnSettings();
			for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
				oSettings.aoPreSearchCols[ iCol ].sSearch = '';
			}
			$('input[aria-controls=<?=$grid_id?>]').val('');			
			grid_<?=$grid_id?>.fnFilter('');
			// grid_<?=$grid_id?>.fnDraw();
		}
		
		$(function(){
			var $container = $("#<?=$grid_id?>").parents('.list_container').eq(0);
			var $search_inputs = $container.find('.search_cols .filter_input');
						
			grid_<?=$grid_id?> = $('#<?=$grid_id?>').dataTable(dtOptions);
			
			$('input[aria-controls=<?=$grid_id?>]').unbind();
			$('input[aria-controls=<?=$grid_id?>]').bind('keyup', function(e) {				
				if(e.keyCode == 13) {
					grid_<?=$grid_id?>.fnFilter(this.value);
				}
			}); 
			
			$('#<?=$grid_id?>').parents('.grid_container').eq(0).find('.grid_yenile').click(function(e){
				e.preventDefault();
				grid_yenile_<?=$grid_id?>();
				return false;
			});
			$container.find('.grid_filter').click(function(e){
				e.preventDefault();
				var oSettings = grid_<?=$grid_id?>.fnSettings();
				$search_inputs.each(function(){
					var col_i = $(this).parents('tr').eq(0).index();
					var sval = this.value;					
					oSettings.aoPreSearchCols[ col_i ].sSearch = sval;
				});
				grid_<?=$grid_id?>.fnDraw();
				return false;
			});			
			$container.find('.grid_export_xls').click(function(e){
				e.preventDefault();
				var oSettings = grid_<?=$grid_id?>.fnSettings();
				var source = oSettings.oInit.sAjaxSource;				
				var params = grid_<?=$grid_id?>._fnAjaxParameters();
				var qs = [];
				$.each(params, function() {
					qs[qs.length] = this.name + '=' + this.value ;
				});
				qs[qs.length] = 'exportXls';
				qs = qs.join('&');
				source = source + '?' + qs;
				window.location = source;				
			});			
			$container.find('.search_cols input').keypress(function(e){				
				if(e.keyCode==13)
				{
					$container.find('.grid_filter').trigger('click');
				}
			});
			$('#<?=$grid_id?> tbody tr').live('dblclick',function(){			
				if($(this).find('.grid_satir_duzenle').length>0)
					$(this).find('.grid_satir_duzenle').trigger('click').focus();
				else
					$(this).find('.grid_satir_goster').trigger('click').focus();
			}).css('cursor','pointer');
		});
		</script>
	</div> <!-- grid_container -->

</div> <!-- list_container -->


