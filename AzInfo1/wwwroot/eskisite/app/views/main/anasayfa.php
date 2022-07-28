<!-- slider start-->
<?php
$banners = AppHelper::getBanner();	
?>
<section class="info-slider uk-slidenav-position" id="info-slider">
    <ul class="uk-slideshow">
		<?php foreach ($banners as $r) { ?>
	        <li><img src="<?= IMAGES_DIR_URL . '/' . $r ?>" width="" height="" alt=""></li>
		<?php } ?>
    </ul>
    <div class="uk-container uk-container-center uk-position-relative">
        <ul class="uk-dotnav uk-position-bottom uk-flex-right">
			<?php foreach ($banners as $i => $r) { ?>
				<li data-uk-slideshow-item="<?= $i ?>"><a href="#"></a></li>
			<?php } ?>
        </ul>
    </div>
    <div class="uk-container uk-container-center uk-position-relative">
        <div class="slider-bottom"></div>
    </div><a class="uk-slidenav uk-slidenav-previous" href="" data-uk-slideshow-item="previous"></a><a class="uk-slidenav uk-slidenav-next" href="" data-uk-slideshow-item="next"></a>
</section>
<?php
$mbanners = AppHelper::getBanner_mobil();
?>
<section class="info-slider-mobile uk-slidenav-position" data-uk-slideshow="{&quot;animation&quot;:&quot;scroll&quot;}">
    <ul class="uk-slideshow">
	<?php foreach($mbanners as $r){ ?>
        <li><img src="<?= IMAGES_DIR_URL.'/'.$r ?>" width="" height="" alt=""></li>
	<?php } ?>
    </ul>
    <ul class="uk-dotnav uk-position-bottom uk-flex-center"> 
    <?php foreach($mbanners as $i=>$r){ ?>
		<li data-uk-slideshow-item="<?=$i?>"><a href="#"></a></li>
	<?php } ?>
    </ul><a class="uk-slidenav uk-slidenav-previous" href="" data-uk-slideshow-item="previous"></a><a class="uk-slidenav uk-slidenav-next" href="" data-uk-slideshow-item="next"></a>
</section>

<section class="info-video">
    <div class="uk-container uk-container-center">
       <?php
	   $videolar = AppHelper::getAnasayfa_video();
	   ?> 
		<div class="uk-grid uk-grid-small">
            <?php foreach($videolar as $v){ ?>
			<div class="uk-width-small-1-2 uk-width-large-1-4 info-video-item">
                <header class="uk-flex uk-flex-middle uk-flex-center uk-text-center">
                    <h4><?=$v['baslik']?></h4>
                </header>
                <section><a class="uk-position-relative" href="<?=$v['url']?>" data-uk-lightbox="{}"><img src="<?= IMAGES_DIR_URL.'/'.$v['resim'] ?>" alt=""></a></section>
            </div>
			<?php } ?>
        </div>
		
        <div class="uk-grid uk-grid-collapse">    
            <div class="uk-width-1-1 info-title uk-text-center">
                <h3>
                    <?=nl2br(ModSiteHelper::get_ayar('metin1_'.LANG))?>
                </h3>
            </div>
        </div>
    </div>
</section>
<section class="info-company">
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-small">
            <div class="uk-width-large-1-2">
                <div class="uk-slidenav-position" data-uk-slider="{}">
                    <h4 class="uk-position-top-left info-home-company-title"><?= _l_html('İNFO <span>TV</span>')?>  </h4>
                    <div class="uk-slider-container">
                        <ul class="uk-slider uk-grid-width-medium-1-1">
                            <li>
                                <div class="uk-grid uk-grid-small">
                                    <div class="uk-width-medium-1-2">
                                        <div class="info-company-home-text">
                                            <p>İstinye park teknik müdürü Cenk Korhan su sistemlerinde nasıl geri kazanım sağladığını anlattı.</p>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <div class="info-company-home-img"><img src="<?= BASE_URL ?>/images/home/info-tv.jpg" alt=""></div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="uk-grid uk-grid-small">
                                    <div class="uk-width-medium-1-2">
                                        <div class="info-company-home-text">
                                            <p>İstinye park teknik müdürü Cenk Korhan su sistemlerinde nasıl geri kazanım sağladığını anlattı.</p>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <div class="info-company-home-img"><img src="<?= BASE_URL ?>/images/home/info-tv.jpg" alt=""></div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="uk-grid uk-grid-small">
                                    <div class="uk-width-medium-1-2">
                                        <div class="info-company-home-text">
                                            <p>İstinye park teknik müdürü Cenk Korhan su sistemlerinde nasıl geri kazanım sağladığını anlattı.</p>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <div class="info-company-home-img"><img src="<?= BASE_URL ?>/images/home/info-tv.jpg" alt=""></div>
                                    </div>
                                </div>
                            </li>
                        </ul><a class="uk-slidenav uk-slidenav-previous" href="" data-uk-slider-item="previous"></a><a class="uk-slidenav uk-slidenav-next" href="" data-uk-slider-item="next"></a>
                    </div><a class="uk-position-bottom-left info-home-company-button" href="#" target="_blank">TÜM VİDEOLAR   </a>
                </div>
            </div>
            <div class="uk-width-large-1-2">
                <div class="uk-slidenav-position" data-uk-slider="{}">
                    <h4 class="uk-position-top-left info-home-company-title"><?= _l('HABERLER') ?> </h4>
                    <div class="uk-slider-container">
                        <ul class="uk-slider uk-grid-width-medium-1-1">
                        <?php
						$haberler = AppHelper::getAnasayfa_haberler();
						foreach($haberler as $h){
						?>
							<li>
                                <div class="uk-grid uk-grid-small">
                                    <div class="uk-width-medium-1-2">
                                        <div class="info-company-home-text">
                                            <p><?=$h['baslik']?></p>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-2">
										<div class="info-company-home-img"><?php if(!empty($h['resim'])){ ?><img src="<?= IMAGES_DIR_URL.'/'.$h['resim'] ?>" alt=""><?php } ?></div>
                                    </div>
                                </div>
                            </li>
						<?php } ?>                            
                        </ul><a class="uk-slidenav uk-slidenav-previous" href="" data-uk-slider-item="previous"></a><a class="uk-slidenav uk-slidenav-next" href="" data-uk-slider-item="next"></a>
                    </div><a class="uk-position-bottom-left info-home-company-button" href="<?= CUrlHelper::getUrl('main/haberler')?>"><?= _l('TÜM HABERLER') ?>       </a>
                </div>
            </div>
        </div>
        <div class="uk-grid uk-grid-collapse">
            <div class="uk-width-1-1 info-title uk-text-center">
                <h3><?=nl2br(ModSiteHelper::get_ayar('metin2_'.LANG))?></h3>
            </div>
        </div>
        <div class="uk-grid uk-grid-small">
		<?php
		$hs = AppHelper::getAnasayfa_hizmet();
		foreach($hs as $h){
		?>
			<div class="uk-width-medium-1-2 uk-width-large-1-4">
                <div class="info-company-home-list-item uk-text-center">
					<a href="javascript:void();">
                        <h3><?=$h['baslik']?></h3>
                        <p><?=$h['yazi']?></p>
						<?php if(!empty($h['resim'])){ ?><img src="<?= IMAGES_DIR_URL.'/'.$h['resim'] ?>" alt=""><?php } ?>
					</a>
				</div>
            </div>
		<?php } ?>
        </div>
    </div>
</section>
<section>
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-small info-company-home-contact">
            <div class="uk-width-large-1-2">
                <div class="info-company-home-contact-left">
                    <header>
                        <h4><?= _l('SORUN, ÇÖZÜM') ?></h4>
                    </header><a class="info-phone" href="tel:0216 471 46 36">0216 471 46 36</a>
                    <ul>
                        <li><a class="info-envelope" href="mailto:<?= ModSiteHelper::get_ayar('sosyal_url1')?>"></a></li>
                        <li><a class="uk-icon-facebook-square" href="<?= ModSiteHelper::get_ayar('sosyal_url2')?>"></a></li>
                        <li><a class="uk-icon-linkedin-square" href="<?= ModSiteHelper::get_ayar('sosyal_url3')?>"></a></li>
                    </ul>
                    <p><?= _l('Su sistemleriniz ile ilgili tüm sorularınızı uzmanlarımıza danışabilirsiniz.') ?>      </p>
                </div>
            </div>
            <div class="uk-width-large-1-2">
                <div class="info-company-home-contact-right">
                    <header><i><img src="<?= BASE_URL ?>/images/home/ok-icon.png" alt=""></i>
                        <h4><?= _l('Su şartlandırma çalışmalarında İnfo Group’u tercih eden kurumlar') ?></h4>
                    </header>
                    <div class="uk-slidenav-position" data-uk-slider="{autoplay: true}">
                        <div class="uk-slider-container">
                            <ul class="uk-slider uk-grid-width-medium-1-4">
							<?php
							$refs = AppHelper::getAnasayfa_referanslar();
							foreach($refs as $r){
							?>	
                                <li>
                                    <div><img src="<?= IMAGES_DIR_URL.'/'.$r ?>"></div>
                                </li>
							<?php } ?>                                
                            </ul>
                        </div><a class="uk-slidenav uk-slidenav-previous" href="" data-uk-slider-item="previous"></a><a class="uk-slidenav uk-slidenav-next" href="" data-uk-slider-item="next"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-grid uk-grid-small info-company-home-logo">
            <div class="uk-width-small-1-2">
                <div class="uk-flex uk-flex-middle left"><a href="#"><img src="<?= BASE_URL ?>/images/home/pulsa-logo.png" alt=""></a><a href="#"><img src="<?= BASE_URL ?>/images/home/pulsafeeder-logo.png" alt=""></a></div>
            </div>
            <div class="uk-width-small-1-2">
                <div class="uk-flex uk-flex-middle right">
				<?php
				$logolar = AppHelper::getAnasayfa_logolar();
				foreach($logolar as $row){
					
					if(!empty($row['resim2'])){ // lightbox linki verilecek
						?><a href="<?= IMAGES_DIR_URL.'/'.$row['resim2']?>" data-uk-lightbox="{group:'anasayfa_logolar'}" target="_blank"><img src="<?= IMAGES_DIR_URL.'/'.$row['resim'] ?>" alt=""></a><?php
					} else {
						?><a href="<?=$row['link']?>" target="_blank"><img src="<?= IMAGES_DIR_URL.'/'.$row['resim'] ?>" alt=""></a><?php
					}
					
					
				}
				?>
				</div>
            </div>
        </div>
    </div>
</section>