<?php

class Field_Files extends CField {

	public $img_path = null;
	public $img_url = null;
	public $file_type = 'file';
	public $max_files = false;
	public $upload_type = 'default';
	public $dir = '';

	public function setDefaults() {
		if ($this->file_type == null) {
			$this->file_type = 'file';
		}
		$dir = $this->dir;
		if(!empty($dir)){
			$dir .= '/';
		}
		switch($this->file_type){
			case 'image':
				if ($this->img_path == null) {
					$this->img_path = IMAGES_PATH . '/' . $dir;
				}
				if ($this->img_url == null) {
					$this->img_url = IMAGES_DIR_URL . '/' . $dir;
				}
			break;
			case 'file':
				if ($this->img_path == null) {
					$this->img_path = FILES_PATH . '/' . $dir;
				}
				if ($this->img_url == null) {
					$this->img_url = FILES_URL . '/' . $dir;
				}
			break;
		}
		
		
	}

	public function parseFiles($data=null) {
		$getTitles = true;
		if ($data == null)
			$data = $this->value;
		$files = array();
		foreach (explode(':', $data) as $file) {
			$parts = explode('|', $file);
			$file_name = $parts[0];
			if (empty($file_name))
				continue;
			$file_title = isset($parts[1]) ? $parts[1] : '';
			if ($getTitles) {
				$files[] = array('file' => $file_name, 'title' => $file_title);
			} else {
				$files[] = $file_name;
			}
		}
		return $files;
	}

	public function db2ui($dbValue=null) {
		if ($dbValue == null)
			$dbValue = $this->value;
		$files = $this->parseFiles($dbValue);
		$arr = array();
		$dir = $this->dir;
		if(!empty($dir)){
			$dir .= '/';
		}
		switch($this->file_type){
			case 'image':
				$DIR_URL = IMAGES_DIR_URL;
				break;
			case 'file':
				$DIR_URL = FILES_URL;
				break;
		}
		foreach ($files as $f) {
			$url = $DIR_URL.'/'.$dir.$f['file'];
			$label = $f['file'] . (!empty($f['title']) ? '(' . $f['title'] . ')' : '');
			$arr[] = '<a href="'.$url.'" target="_blank">'.$label.'</a>';
		}
		
		return implode(', ', $arr);
	}

	public function showInput() {
		$this->setDefaults();
		$files = $this->parseFiles();


		if( (empty($this->upload_type)||$this->upload_type=='default') && $this->max_files != 1){
			$this->upload_type = 'plupload';
		}

		$modelName = $this->ownerForm->ownerModel->_modelName;

		in_array($this->file_type, array('file', 'image')) || $this->file_type = 'file';
		
		$show_thumbs = ($this->file_type=='image' && $this->show_thumbs) ;
		
		$aa = _getAppData('active_action');
		$arr = explode('/', $aa, 2);
		$controller = $arr[0];

		$upload_action = CUrlHelper::getModXUrl('mod_admin', $controller . '/upload_' . $this->file_type, array('model' => $modelName, 'field' => $this->name));
		$delete_action = CUrlHelper::getModXUrl('mod_admin', $controller . '/delete_' . $this->file_type, array('model' => $modelName, 'field' => $this->name));
		
		$kcfinder_url = ASSET_URL.'/js/kcfinder';
		
		?>
		<style type="text/css">
			.sortable , .sortable_thumbs{ list-style-type: none; margin: 0; padding: 0; }
			
			.sortable_thumbs li { margin: 3px 3px 3px 0; padding: 1px; float: left; height: 100px;border:1px solid silver;cursor:pointer;background:#f0f0f0;}
			.sortable_thumbs li img {height:90px;margin-top:5px;}
			.sortable_thumbs li a {text-decoration:none; float:left;}
			.sortable_thumbs li .ui-icon {float:left;}

			.sortable li { padding: 3px; cursor:pointer;}
			.sortable li span {float:left;}
			
			.sortable li .delete, .sortable_thumbs li .delete{ cursor:pointer;}
		</style>
		<div id="<?= $this->id ?>">
			<input type="hidden" class="files_data" name="<?= $this->name ?>" value="<?= $this->value ?>">
			<?php 
			switch ($this->upload_type) {
				case 'plupload':
					?>
					
					<div id="container_<?=$this->id?>" style="margin-bottom:10px;">
						<div class="grid_menu ui-widget icon-collection browseGroup">
							<span class="ui-state-default ui-corner-all"><a class="grid_arama" id="kcfinder_button_<?= $this->id ?>"><?=_mlang($this->file_type=='image'?'Images':'Files','main','mod_admin')?></a></span>
							<button id="pickfiles_<?=$this->id?>" class="browse"><?=_mlang('Select files','main','mod_admin')?></button>
						</div>
						
						<span class="uploading" style="display:none;"><?= _mlang('Loading', 'main', 'mod_admin') ?>...</span>
						<div id="errorlist_<?=$this->id?>" style="margin-top:10px;"></div>
						<?php /*<div id="filelist_<?=$this->id?>" style="margin-top:10px;"></div>
						<button id="uploadfiles_<?=$this->id?>">Upload</button>*/?>
					</div>


					<script type="text/javascript">
					// Custom example logic
					<?php $uploader = 'uploader_'.$this->id ;?>
					$(function() {
						var <?=$uploader?> = new plupload.Uploader({
							//runtimes : 'gears,html5,flash,silverlight,browserplus',
							runtimes : 'gears,html5,flash,silverlight',
							browse_button : 'pickfiles_<?=$this->id?>',
							container : 'container_<?=$this->id?>',
							max_file_size : '32mb',
							url : '<?=$upload_action?>',
							flash_swf_url : '<?=ASSET_URL.'/js'?>/plupload/js/plupload.flash.swf',
							silverlight_xap_url : '<?=ASSET_URL.'/js'?>/plupload/js/plupload.silverlight.xap',
							filters : [
								<?php if($this->file_type=='image'){?>
								{title : "Image files", extensions : "jpg,jpeg,gif,png"}
								<?php } else { ?>
								{title : "Files", extensions : "*"}
								<?php }?>
							]
							//,resize : {width : 320, height : 240, quality : 90}
						});

						<?=$uploader?>.bind('Init', function(up, params) {
							//$('#filelist_<?=$this->id?>').html("<div>Current runtime: " + params.runtime + "</div>");
						});
						<?php /*
						$('#uploadfiles_<?=$this->id?>').click(function(e) {
							<?=$uploader?>.start();
							e.preventDefault();
						});*/
						?>

						<?=$uploader?>.init();

						<?=$uploader?>.bind('FilesAdded', function(up, files) {
							$.each(files, function(i, file) {
								/*
								$('#filelist_<?=$this->id?>').append(
									'<div id="' + file.id + '">' +
									file.name + ' (' + plupload.formatSize(file.size) + ') <b></b> FilesAdded' +
								'</div>');*/
								addFileRow_<?= $this->id ?>(file.name, false,file.id,true);
							});
							up.refresh(); // Reposition Flash/Silverlight
							checkMaxFiles_<?= $this->id ?>();
							$('#<?= $this->id ?> .uploading').show();
							<?=$uploader?>.start();
						});

						<?=$uploader?>.bind('UploadComplete', function(up, files) {
							$('#<?= $this->id ?> .uploading').hide();
							refreshData_<?= $this->id ?>();
						});

						<?=$uploader?>.bind('UploadProgress', function(up, file){
							$('#<?=$this->id?> ul.filelist li[rel="'+file.name+'"] .progress').html(file.percent +'%');
						});

						<?=$uploader?>.bind('Error', function(up, err) {
							$('#errorlist_<?=$this->id?>').append("<div><?=_mlang('Error','main','mod_admin')?>: " + err.code +
								", " + err.message +
								(err.file ? ", <?=_mlang('File','main','mod_admin')?>: " + err.file.name : "") +
								"</div>"
							);
							up.refresh(); // Reposition Flash/Silverlight
						});

						<?=$uploader?>.bind('FileUploaded', function(up, file,res) {
							//$('#' + file.id + " b").html("100%");
							json = eval("("+res.response+")");
							if(json.error!=undefined)
							{
								notify(json.error + '( '+file.name+' )','error');
								$('#'+file.id).remove();
							}
							else if(json.file!=undefined){								
								$('#'+file.id).attr('rel',json.file);
								
								$('#'+file.id+ ' a').each(function(){
									var a = $(this);
									var src_prefix = a.attr('src_prefix');									
									if(src_prefix!=undefined){
										a.attr('href', src_prefix+json.file);
										a.find('img').attr('src', src_prefix+json.file);										
									}
								});
							}
						});
					});
					</script>
					<?php 
					break;

				case 'default':
				default:
				?>
				<div class="grid_menu ui-widget icon-collection browseGroup">
					<span class="ui-state-default ui-corner-all"><a class="grid_arama" id="kcfinder_button_<?= $this->id ?>"><?=_mlang($this->file_type=='image'?'Gallery':'Gallery','main','mod_admin')?></a></span>
					<input type="file" class="browse" id="browse_<?= $this->id ?>"></input>
				</div>
				
				<div class="uploading" style="display:none;"><?= _mlang('Loading', 'main', 'mod_admin') ?>...</div>
				<script type="text/javascript">
					var upload_stack= [];
					
					$('#<?= $this->id ?> .browse').change(function(){
						upload_stack.push(1);
						$('#<?= $this->id ?> .uploading').show();

						$(this).fileupload({
							action:'<?= $upload_action ?>',
							type:'json',
							callback:function(res){
								if(res.error!=undefined)
								{
									notify(res.error,'error');
								}
								else if(res.file!=undefined)
								{
									addFileRow_<?= $this->id ?>(res.file);
									upload_stack.pop();
									if(upload_stack.length==0){
										$('#<?= $this->id ?> .uploading').hide();
									}
								}
								// to reset value of file input
								//document.getElementById('browse_<?= $this->id ?>').setAttribute('type', 'input');
								//document.getElementById('browse_<?= $this->id ?>').setAttribute('type', 'file');
							}
						});
					});
				</script>
				<?php 
			}
			?>
			<ul class="filelist sortable<?=$show_thumbs?'_thumbs':''?>"></ul>
		</div>
		<?php 
		$size_options = isset($this->size_options) ? $this->size_options : array();
		$url_root = $this->img_url;
		$has_size = count($size_options) > 0;
		?>
		<script type="text/javascript">
			var $li=null;
			var hasSize = <?= $has_size ? 'true' : 'false' ?>;
			
			function openKCFinder_singleFile_<?= $this->id ?>() {
				window.KCFinder = {};
				window.KCFinder.callBack = function(url) {
					window.KCFinder = null;
					var file = url.replace(/^.*(\\|\/|\:)/, '');
					addFileRow_<?= $this->id ?>(file);
				};
				var left = (screen.width/2)-(800/2);
				var top = (screen.height/2)-(600/2);
				window.open('<?=$kcfinder_url?>/browse.php?opener=custom&type=<?=($this->file_type=='image'?'images':'files')?>&lang=<?=LANG?>','kcfinder_window_<?= $this->id ?>','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=800, height=600, top='+top+', left='+left);
			}
			function openKCFinder_multipleFiles_<?= $this->id ?>() {
				window.KCFinder = {};
				window.KCFinder.callBackMultiple = function(files) {
					window.KCFinder = null;
					var url = '';
					var file = '';
					var i=0;
					for (i=0; i < files.length; i++) {
						url = files[i];
						file = url.replace(/^.*(\\|\/|\:)/, '');
						addFileRow_<?= $this->id ?>(file);
					}
				};
				var left = (screen.width/2)-(800/2);
				var top = (screen.height/2)-(600/2);
				window.open('<?=$kcfinder_url?>/browse.php?opener=custom&type=<?=($this->file_type=='image'?'images':'files')?>&lang=<?=LANG?>','kcfinder_window_<?= $this->id ?>','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=800, height=600, top='+top+', left='+left);
			}

			function checkMaxFiles_<?= $this->id ?>()
			{
				<?php if ($this->max_files > 0): ?>
				var max_files = <?= $this->max_files ?>;
				var n = $('#<?= $this->id ?> .filelist li').length;
				if(n>=max_files){
					$('#<?= $this->id ?> .browseGroup').hide();
				}
				else
				{
					$('#<?= $this->id ?> .browseGroup').show();
				}
				<?php endif; ?>
			}

			function refreshData_<?= $this->id ?>()
			{
				var files = [];
				var data = '';
				$('#<?= $this->id ?> .filelist li').each(function(){
					var fname = $(this).attr('rel');
					files[files.length] = fname+'|';
				});
				data = files.join(':');
				$('#<?= $this->id ?> input[name=<?= $this->name ?>]').val(data);
				checkMaxFiles_<?= $this->id ?>();
			}

			function refreshList_<?= $this->id ?> ()
			{
				var data = $('#<?= $this->id ?> input[name=<?= $this->name ?>]').val();
				var files = [];
				files = data.split(':');
				$('#<?= $this->id ?> .filelist li').remove();
				for(var i in files)
				{
					var arr = files[i].split('|',2);
					var file = arr[0];
					if(file!='')
						addFileRow_<?= $this->id ?>(file);
				}
				checkMaxFiles_<?= $this->id ?>();
			}

			function addFileRow_<?= $this->id ?>(file,runRefreshData,file_id,loading)
			{
				if(runRefreshData==undefined) runRefreshData = true;
				if(loading==undefined) loading = false;
				<?php 
				if($show_thumbs){
					$prefix = '';
					if ($has_size ) {
						foreach ($this->size_options as $opt) {
							$prefix = $opt['prefix'];
							?>							
							var img_thumb = '<?= $url_root . $prefix ?>'+file;
							<?php 
							break;
						}
					}
					else{
						?>var img_thumb = '<?= $url_root ?>'+file;<?php 
					}
					?>
					if(loading){
						var img_thumb = '<?= ASSET_URL ?>/images/icon_loading.gif' ;
					}
					$('#<?= $this->id ?> .filelist').append('<li rel="'+file+'" '+ (file_id!=undefined? 'id="'+file_id+'"' : '') +'> <span class="ui-icon ui-icon-arrow-4"></span> <a src_prefix="<?= $url_root . $prefix ?>" rel="<?=$this->name?>" title="<?=$this->label?>" href="'+img_thumb+'" target="_blank"> <img src="'+img_thumb+'"></img></a><span class="ui-icon ui-icon-closethick delete"></span>  <br /> <b class="progress"></b></li>');
					<?php 					
				}
				else{
					?>
					var links = '<a class="" src_prefix="<?=$url_root?>" rel="<?=$this->name?>" title="<?=$this->label?>" href="<?= $url_root ?>'+file+'" target="_blank">'+file+'</a>';
					<?php 
					if ($this->file_type == 'image') {
						if ($has_size && !($this->original_max_width>0 || $this->original_max_height>0) ) {
							?>links='';<?php 
						}

						foreach ($this->size_options as $opt) {
							$prefix = $opt['prefix'];
							$src_prefix = $url_root . $prefix;
							?>links=links+'&nbsp;<a src_prefix="<?=$src_prefix?>" rel="<?=$this->name?>" title="<?=$this->label?>" href="<?= $src_prefix ?>'+file+'" target="_blank"><?= $prefix ?>'+file+'</a>';<?php 
						}
					}
					?>
					$('#<?= $this->id ?> .filelist').append('<li rel="'+file+'" '+ (file_id!=undefined? 'id="'+file_id+'"' : '') +'><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> <span class="ui-icon ui-icon-closethick delete"></span> '+links+' <b class="progress"></b></li>');
					<?php 
				}
				?>				
				
				<?php if($this->file_type == 'image'){ ?>
				$('#<?= $this->id ?> .filelist li a').fancybox({
					centerOnScroll:true
				});
				<?php } ?>
				
				if(runRefreshData){
					refreshData_<?= $this->id ?>();
				}
			}

			$(function(){
				refreshList_<?= $this->id ?>();
				
				$('#<?= $this->id ?>').parents('form').eq(0).bind('reset',function(){					
					$('#<?= $this->id ?> input[name=<?= $this->name ?>]').val('<?=$this->value?>');
					refreshList_<?= $this->id ?>();
				});
				
				$('#kcfinder_button_<?= $this->id ?>').click(function(e){
					e.preventDefault();
					<?php if($this->max_files==1){ ?>
						openKCFinder_singleFile_<?= $this->id ?>();
					<?php } else { ?>
						openKCFinder_multipleFiles_<?= $this->id ?>();
					<?php } ?>	
					return false;
				});

				$('#<?= $this->id ?> ul li .delete').live('click',function(e){
					var $li = $(this).parents('li').eq(0);
					var filename = $li.attr('rel');
					$li.remove();
					refreshData_<?= $this->id ?>();
					<?php /*  // disabled file deleting (uploaded files may be reused through file browser)
					if(confirm('<?= _mlang('Delete', 'main', 'mod_admin') ?>: '+filename+' ?'))
					{
						$.post('<?= $delete_action ?>',{'file':filename},function(json)
						{
							if(json.error!=undefined)
							{
								notify(json.error,'error');
							}
							else if(json.success!=undefined)
							{
								$li.remove();
								refreshData_<?= $this->id ?>();
							}
						},'json');
					}*/?>
				});

				$('#<?= $this->id ?> ul').sortable({
					opacity:0.6,
					tolerance: 'pointer',
					stop: function(event, ui) { refreshData_<?= $this->id ?>(); }
				});

			});
			</script>
			<?php 
		}
	}

