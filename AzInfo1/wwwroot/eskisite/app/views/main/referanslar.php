<section class="info-references">
	<div class="info-references-nav">
        <div class="uk-container uk-container-center">
			<div class="uk-grid">
				<div class="uk-width-1-1">
					<ul class="uk-tab" data-uk-tab="{connect:'#my-id'}">
						<li><a href="#"><?= _l('TÜMÜ') ?></a></li>
						<?php foreach($sekmeler as $s=>$rows){ ?>
						<li><a href=""><?=$s?></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
        </div>
	</div>
	<div class="info-references-content">
        <div class="uk-container uk-container-center">
			<div class="uk-grid">
				<div class="uk-width-1-1">
					<ul class="uk-switcher" id="my-id">
						<li>
							<div class="uk-grid uk-grid-small">
							<?php foreach($tumu as $row){ ?>	
								<div class="uk-width-1-2 uk-width-small-1-4 uk-width-medium-1-6 info-references-item">
									<div class="uk-flex uk-flex-middle uk-flex-center"><img src="<?= IMAGES_DIR_URL . '/'.$row['logo'] ?>" alt="<?= $row['baslik'] ?>"></div>
								</div>
							<?php } ?>
							</div>
						</li>
					<?php foreach($sekmeler as $s=>$rows){ ?>
						<li>
						<?php
						$gruplar = array_chunk($rows, 2);
						foreach($gruplar as $g){
						?>
							<div class="uk-grid uk-grid-collapse info-references-grid">							
							<?php foreach($g as $row){ ?>
								<div class="uk-width-large-1-2 info-references-item-detail">
									<div class="uk-grid">
										<div class="uk-width-small-2-6">
											<div class="info-references-img uk-flex uk-flex-middle uk-flex-center"><img src="<?= IMAGES_DIR_URL . '/'.$row['logo'] ?>" alt="<?=$row['baslik']?>"></div>
											<?php /* <div class="info-references-doc">
												<ul class="uk-flex uk-flex-wrap">													
													<li><a href="#" target="_blank"><img src="<?= BASE_URL . '/' ?>images/references/envelope-icon.png" alt=""></a></li>
													<li><a href="#" target="_blank"><img src="<?= BASE_URL . '/' ?>images/references/envelope-icon.png" alt=""></a></li>
													<li><a href="#" target="_blank"><img src="<?= BASE_URL . '/' ?>images/references/envelope-icon.png" alt=""></a></li>
													<li><a href="#" target="_blank"><img src="<?= BASE_URL . '/' ?>images/references/envelope-icon.png" alt=""></a></li>
												</ul>
											</div>*/?>
											<div class="info-references-video">
												<ul class="uk-flex uk-flex-wrap">
												<?php foreach($row['videolar'] as $v){ if(empty($v)){ continue; } ?>	
													<li><a href="<?=$v?>" data-uk-lightbox="{}"><img src="<?= BASE_URL . '/' ?>images/references/play-icon.png" alt=""></a></li>
												<?php } ?>
													
												<?php if(!empty($row['mektup'])){ ?>	
													<li><a href="<?= FILES_URL.'/'.$row['mektup']?>" target="_blank"><img src="<?= BASE_URL . '/' ?>images/references/envelope-icon.png" alt=""></a></li>
												<?php } ?>	
												</ul>
											</div>
										</div>
										<div class="uk-width-small-4-6">
											<h2><?=$row['baslik']?></h2>
											<p><?=$row['aciklama']?></p>
										</div>
									</div>
								</div>
							<?php } ?>
							</div>
						<?php } ?>
						</li>
					<?php } ?>
					</ul>
				</div>
			</div>
        </div>
	</div>
</section>
