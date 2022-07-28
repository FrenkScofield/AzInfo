<section class="info-products-detail">
	<div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-small">
			<div class="uk-width-large-1-4 uk-text-center">
				<div class="info-products-item">
					<div>
						<a href="javascript:void();">
							<?php if(!empty($kategori_simge)){ ?>
							<img src="<?=IMAGES_DIR_URL.'/'.$kategori_simge?>" alt="<?=$kategori_baslik?>">
							<?php } ?>
							<h3><?=$kategori_baslik?></h3>
						</a>
					</div>
				</div>
			</div>
			<div class="uk-width-large-3-4">
				<?php foreach($rows as $row){ ?>
				<div class="info-products-detail-item">
					<h4><?=$row['baslik']?></h4>
					<p><?=$row['aciklama']?></p>
					
					<?php if(count($row['resimler'])){ ?>
					<div class="uk-slidenav-position" data-uk-slider="{infinite:false}">
						<div class="uk-slider-container">
							<ul class="uk-grid uk-grid-small uk-slider uk-grid-width-small-1-2 uk-grid-width-medium-1-4 uk-grid-width-large-1-6">
							<?php foreach($row['resimler'] as $r){ ?>	
								<li><a href="<?=IMAGES_DIR_URL.'/'.$r?>"title="<?=$row['baslik']?>" data-uk-lightbox="{group:'1'}"><img src="<?=IMAGES_DIR_URL.'/'.$r?>" alt=""></a></li>
							<?php } ?>
							</ul>
						</div><a class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" href="" data-uk-slider-item="previous"></a><a class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" href="" data-uk-slider-item="next"></a>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
        </div>
	</div>
</section>
