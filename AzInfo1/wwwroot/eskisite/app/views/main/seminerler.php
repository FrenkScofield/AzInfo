<section class="info-seminar">
	<div class="uk-container uk-container-center">
        <div class="uk-grid">
			<div class="uk-width-medium-1-1 uk-margin-bottom">
				<?=$yazi?>
			</div>
			<div class="uk-width-1-1">
				<div class="uk-accordion" data-uk-accordion>
				<?php foreach($rows as $row){ ?>	
					<h3 class="uk-accordion-title uk-flex uk-flex-space-between uk-flex-middle"><?=$row['baslik']?><i class="uk-icon-chevron-down"></i><i class="uk-icon-chevron-up"> </i></h3>
					<div class="uk-accordion-content">
						<div class="uk-slidenav-position" data-uk-slider="{infinite: false}">
							<div class="uk-slider-container">
								<ul class="uk-grid uk-grid-small uk-slider uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-6">
								<?php foreach($row['resimler'] as $r){ ?>	
									<li>
										<div class="info-seminar-item"><a class="uk-flex uk-flex-middle uk-flex-center" href="<?= IMAGES_DIR_URL.'/'.$r?>" title="<?=$row['baslik']?>"  data-uk-lightbox><img src="<?= IMAGES_DIR_URL.'/'.$r?>" alt=""></a></div>
									</li>						
								<?php } ?>
								</ul>
							</div>
							<?php if(count($row['resimler'])){?><?php } ?>
						</div>
					</div>
				<?php } ?>	
					
				</div>
			</div>
        </div>
	</div>
</section>