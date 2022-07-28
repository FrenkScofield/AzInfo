<?php

class Field_Cke extends CField
{
	public $allowHtml = true;
		
	
	public function db2ui($dbValue=null)
	{
		if($dbValue==null) $dbValue = $this->value;
		//return strip_tags($dbValue);
		return ModAdminHtmlHelper::summary( html_entity_decode($dbValue,ENT_QUOTES,'utf-8'),150);
	}
	
	public function showInput()
	{
		//$ckfinder_url = ASSET_URL.'/js/ckfinder';
		$kcfinder_url = ASSET_URL.'/js/kcfinder';
		$html = htmlentities($this->value,ENT_QUOTES,'utf-8');
						
		?><textarea class="wide" id="<?=$this->id?>" name="<?=$this->name?>"><?=$html?></textarea>
		<script type="text/javascript">
		var CKEDITOR_BASEPATH = '<?=ASSET_URL.'/js'?>/ckeditor/';
		</script>
		<script type="text/javascript" src="<?=ASSET_URL.'/js/ckeditor/ckeditor.js'?>"></script>
		<script type="text/javascript" src="<?=ASSET_URL.'/js/ckeditor/adapters/jquery.js'?>"></script>
		<script type="text/javascript">		
		$(function(){
			$('#<?=$this->id?>').ckeditor({
				filebrowserBrowseUrl : '<?=$kcfinder_url?>/browse.php?opener=ckeditor&type=files',
				filebrowserImageBrowseUrl : '<?=$kcfinder_url?>/browse.php?opener=ckeditor&type=images',
				filebrowserFlashBrowseUrl : '<?=$kcfinder_url?>/browse.php?opener=ckeditor&type=flash',
				filebrowserUploadUrl : '<?=$kcfinder_url?>/upload.php?opener=ckeditor&type=files',
				filebrowserImageUploadUrl : '<?=$kcfinder_url?>/upload.php?opener=ckeditor&type=images',
				filebrowserFlashUploadUrl : '<?=$kcfinder_url?>/upload.php?opener=ckeditor&type=flash'
			});
		});
		</script>
		<?php 
	}
}
