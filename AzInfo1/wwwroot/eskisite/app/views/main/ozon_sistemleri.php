<section class="info-products">
	<div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-small">
		<?php foreach($rows as $row){ ?>
			<div class="uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-4 uk-text-center info-products-item">
				<div>
					<a href="<?= $row['url'] ?>">
						<?php if(!empty($row['simge'])){ ?>
							<img src="<?= IMAGES_DIR_URL .'/'.$row['simge'] ?>" alt="<?=$row['baslik']?>">
						<?php } ?>
						<?php if(!empty($row['simge2'])){ ?>
							<img src="<?= IMAGES_DIR_URL .'/'.$row['simge2'] ?>" class="hover" alt="<?=$row['baslik']?>">
						<?php } ?>
						<h3><?=$row['baslik']?></h3>
					</a>
				</div>
			</div>
		<?php } ?>
        </div>
	</div>
</section>
