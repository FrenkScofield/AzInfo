<?php

class Field_Tinymce extends CField
{
	public $allowHtml = true;
	
	public $template_external_list_url = '';
	
	public function db2ui($dbValue=null)
	{
		if($dbValue==null) $dbValue = $this->value;
		//return strip_tags($dbValue);
		return HtmlHelper::kisalt( html_entity_decode($dbValue,ENT_QUOTES,'utf-8'),150);		
	}
	
	public function showInput()
	{
		$script_url = is_file(APP_PATH.'/modules/mod_admin/assets/js/tiny_mce/tiny_mce.js')
			? APP_URL.'/modules/mod_admin/assets/js/tiny_mce/tiny_mce.js'
			: BASE_URL.'/js/tiny_mce/tiny_mce.js'
		;
		
		$html = htmlentities($this->value,ENT_QUOTES,'utf-8');
		?><textarea id="<?=$this->id?>" name="<?=$this->name?>"><?=$html?></textarea>
		<script type="text/javascript">
		$(function(){			
			$('#<?=$this->id?>').tinymce({
				// Location of TinyMCE script
				script_url : '<?=$script_url?>',
				// General options
				theme : "advanced",
				plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

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
				theme_advanced_resizing : true
			});
		});
		</script>
		<?php 
	}
}
