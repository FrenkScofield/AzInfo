<section class="info-documents">
	<div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-small">
		<?php foreach($rows as $row){ 
			$img = BASE_URL.'/images/documents/document-icon.png';
			if(!empty($row['resim'])){
				$img = IMAGES_URL.'/belge_'.$row['resim'];
			}
			?>	
			<div class="uk-width-small-1-2 uk-width-medium-1-4 uk-width-large-1-6 info-doc-item">
				<a href="<?= (!empty($row['dosya'])? FILES_URL.'/'.$row['dosya'] :'javascript:void();')?>" target="_blank">
					<div class="info-doc-img uk-flex uk-flex-middle uk-flex-center"><img src="<?=$img?>" alt="<?=$row['baslik']?>"></div>
					<p class="uk-text-center"><?=$row['baslik']?>  </p>
				</a>
			</div>
		<?php } ?>			
        </div>
	</div>
</section>

