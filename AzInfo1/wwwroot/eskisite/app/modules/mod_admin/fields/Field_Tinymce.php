<?php

class Field_Tinymce extends CField
{
	public $allowHtml = true;
	
	public $template_external_list_url = '';
	
	public function db2ui($dbValue=null)
	{
		if($dbValue==null) $dbValue = $this->value;
		//return strip_tags($dbValue);
		return ModAdminHtmlHelper::summary( html_entity_decode($dbValue,ENT_QUOTES,'utf-8'),150);
	}
	
	public function showInput()
	{
		$html = htmlentities($this->value,ENT_QUOTES,'utf-8');
		
		if(empty($this->template_external_list_url)){
			$this->template_external_list_url = CUrlHelper::getModXUrl('mod_admin','main/template_list');
		}
		
		?><textarea id="<?=$this->id?>" name="<?=$this->name?>"><?=$html?></textarea>
		<script type="text/javascript">
		function openKCFinder_<?=$this->id?> (field_name, url, type, win) {
			tinyMCE.activeEditor.windowManager.open({
				file: '<?=ASSET_URL?>/js/kcfinder/browse.php?opener=tinymce&type=' + type,
				title: 'KCFinder',
				width: 700,
				height: 500,
				resizable: "yes",
				inline: true,
				close_previous: "no",
				popup_css: false
			}, {
				window: win,
				input: field_name
			});
			return false;
		}
		$(function(){			
			$('#<?=$this->id?>').tinymce({
				// Location of TinyMCE script
				script_url : '<?=ASSET_URL.'/js/'?>tiny_mce/tiny_mce.js',				
				// General options
				theme : "advanced",
				plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",				
				extended_valid_elements : "iframe[src|width|height|name|align|frameborder|marginheight|marginwidth|scrolling]",
				<?php 
				if(!empty($this->template_external_list_url)){
					?>template_external_list_url : "<?=$this->template_external_list_url?>",<?php 
				}
				?>
				// Theme options
				theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,
				file_browser_callback: 'openKCFinder_<?=$this->id?>'
			});
			
			
		});
		</script>
		<?php 
	}
}
