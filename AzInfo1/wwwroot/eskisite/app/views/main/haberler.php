<section class="info-news">
	<div class="uk-container uk-container-center">
        <?php foreach($rows as $row){ ?>
		<div class="uk-grid uk-grid-collapse info-news-grid">
			<div class="uk-width-large-1-2 info-news-text">
				<h2><?=$row['baslik']?></h2>
				<p><?=$row['aciklama']?></p>
			</div>
			<div class="uk-width-large-1-2">
				<div class="uk-grid uk-grid-small">
				<?php foreach($row['resimler'] as $r){ ?>	
					<div class="uk-width-small-1-2 uk-width-medium-1-4"><a href="<?= IMAGES_DIR_URL .'/'.$r ?>" title="<?=$row['baslik']?>" data-uk-lightbox="{group:'1'}"><img src="<?= IMAGES_DIR_URL .'/'.$r ?>" alt=""></a></div>
				<?php } ?>					
				</div>
			</div>
        </div>
        <?php } ?>
	</div>
</section>
