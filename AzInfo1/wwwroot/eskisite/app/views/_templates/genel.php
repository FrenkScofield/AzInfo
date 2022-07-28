<?php
$ustbanner = _getAppData('ustbanner');
if(!empty($ustbanner)){
	$img = IMAGES_DIR_URL.'/'.$ustbanner;
}
else {
	$img = BASE_URL.'/images/company/about-banner.jpg';
}

?>
<section class="info-page-header">
    <div class="info-page-banner" style="background-image: url(&quot;<?= $img ?>&quot;);">
		<img src="<?= $img ?>" alt="">
		<div class="info-breadcrumb">
			<div class="uk-container uk-container-center">
				<div class="uk-flex uk-flex-middle uk-flex-space-between info-breadcrumb-flex">
					<span class="info-breadcrumb-title"><?= _getAppData('ustbaslik') ?></span>
					<ul class="uk-breadcrumb">						
						<li><a href="<?=CUrlHelper::getUrl('main/index')?>"><?= _l('Anasayfa') ?></a></li>
					<?php
					$bc = _getAppData('bcArr');
					if(!is_array($bc)) { $bc = array(); }
					$last = count($bc)-1;
					foreach($bc as $i=>$a){
						if($i==$last){
							?><li class="uk-active"><span><?=$a['title']?></span></li><?php
						} else {
							?><li><a href="<?=$a['href']?>"><?= $a['title'] ?></a></li><?php
						}
					}
					?>
						
					</ul>
				</div>
			</div>
		</div>
    </div>
</section>

<?= $_view_content ?>