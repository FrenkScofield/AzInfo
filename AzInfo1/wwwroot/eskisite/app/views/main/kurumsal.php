<section class="info-company">
    <div class="uk-container uk-container-center">
        <div class="uk-grid"> 
			<div class="uk-width-large-2-3 info-company-text">
				<div class="info-company-content">
					<article>
						<h1><?=$baslik?></h1>						
						<?= $yazi ?>
					</article>
				</div>
			</div>
			<div class="uk-width-large-1-3 uk-text-center-medium"><?php if(!empty($resim)){ ?><img src="<?= IMAGES_DIR_URL . '/'.$resim ?>" alt=""><?php } ?></div>
        </div>
    </div>
</section>
