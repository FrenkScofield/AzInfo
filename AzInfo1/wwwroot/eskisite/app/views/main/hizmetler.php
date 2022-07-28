<section class="info-services">
    <div class="uk-container uk-container-center">
        
		<?php foreach($rows as $gi=>$row){ ?>
		<div class="uk-grid info-services-grid">
			<div class="uk-width-medium-2-6 uk-text-center-medium"><?php if(!empty($row['resim'])){ ?><img src="<?= IMAGES_DIR_URL . '/'.$row['resim'] ?>" alt=""><?php } ?></div>
			<div class="uk-width-medium-4-6 info-services-text">
				<div class="uk-grid uk-grid-collapse">
					<div class="uk-width-1-1">
						<h2><?=$row['baslik']?></h2>
						<p><?=$row['aciklama']?></p>
					</div>
					<div class="uk-width-1-1">
						<div class="info-services-gallery">
							<div class="uk-slidenav-position" data-uk-slider="{infinite: false}">
								<div class="uk-slider-container">
									<ul class="uk-grid uk-grid-small uk-slider uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-5">
									<?php foreach($row['galeri'] as $g){
										$resim = $g['resim'];
										
										if(!empty($g['link'])){
											$link = $g['link'];
										} else {
											$link = IMAGES_DIR_URL . '/'.$resim;
										}										
										?>
										<li><a href="<?= $link ?>" class="uk-flex uk-flex-center" title="<?=$row['baslik']?>" data-uk-lightbox="{group:'<?=$gi?>'}"><img src="<?= IMAGES_URL . '/hizmet_'.$resim ?>" alt=""></a></li>
									<?php } ?>
									</ul>
								</div><a class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" href="" data-uk-slider-item="previous"></a><a class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" href="" data-uk-slider-item="next"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
		<?php } ?>
    </div>
</section>