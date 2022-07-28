<section class="info-documents">
	<div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-small">
			
			<?php foreach($rows as $row){
				$img = BASE_URL.'/images/documents/document-icon.png';
				if(!empty($row['resim'])){
					$img = IMAGES_URL.'/nsf_'.$row['resim'];
				}
				?>
			<div class="uk-width-small-1-2 uk-width-medium-1-4 uk-width-large-1-6 info-doc-item">
				<a href="<?=$row['link']?>" data-uk-lightbox>
					<div class="info-doc-img uk-flex uk-flex-middle uk-flex-center">
						<img src="<?=$img?>" alt="">
					</div>
					<p class="uk-text-center"><?=$row['isim']?></p>
				</a>
			</div>
			<?php } ?>
			
        </div>
	</div>
</section>

