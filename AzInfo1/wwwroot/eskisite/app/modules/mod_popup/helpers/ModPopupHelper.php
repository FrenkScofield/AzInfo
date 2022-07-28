<?php

class ModPopupHelper extends CHelper
{
	
	public static function popupHtml($bolum='site')
	{
		require_once APP_PATH.'/modules/mod_popup/models/ModPopupPopupModel.php';
		
		if(!isset($_SESSION['mod_popup_used']) || !is_array($_SESSION['mod_popup_used'])){
			$_SESSION['mod_popup_used'] = array();
		}
		
		$lang = _getAppData('lang');
		
		$bugun = date('Y-m-d');
		
		$model = new ModPopupPopupModel();
		if($model
			->where(" `aktif`='1' AND dil='$lang' AND (`bas_tarih` IS NULL OR `bas_tarih`<='$bugun' ) AND (`bit_tarih` IS NULL OR `bit_tarih`>='$bugun' ) ")
			->orderBy('`sira` ASC')
			->find()
		){
			$resim = CImageHelper::getFirstValid($model->resim);
			$link = $model->link;
			if(empty($resim) || ( /*!IS_LOCALHOST &&*/ isset($_SESSION['mod_popup_used'][$model->getId()])) ){
				return;
			}
			$_SESSION['mod_popup_used'][$model->getId()] = true;
			?>			
			<script type="text/javascript">
			$(function(){				
				var lightbox = UIkit.lightbox.create([					
					{'source': '<?=IMAGES_DIR_URL?>/<?=$resim?>', 'type':'image'}
				]);

				lightbox.show();				
			});
			</script>
			<?php 
		}
	}
}
