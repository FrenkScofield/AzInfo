<section class="info-products-ozon">
	<div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-medium">
			<div class="uk-width-medium-2-3">
				<div class="info-products-ozon-header uk-flex uk-flex-middle uk-flex-space-between">
					<h2><?= _l('ÜRÜN AÇIKLAMASI') ?></h2><?php if(!empty($link)){ ?><a href="<?=$link?>" target="_blank"><?= _l('ONLINE SATIŞ') ?></a><?php } ?>
				</div>
				<div class="info-products-ozon-text">
					<?=$aciklama?>
				</div>
			</div>
			<div class="uk-width-medium-1-3 info-ozon-img"><?php if(!empty($resim)){ ?><img src="<?= IMAGES_DIR_URL .'/'.$resim ?>" alt="<?=$baslik?>"><?php } ?></div>
			<div class="uk-width-medium-1-2 uk-width-xlarge-1-3">
				<div class="info-products-ozon-section">
					<h3><?= _l('UYGULAMA ALANLARI') ?></h3>
					<?=$kutu1?>
				</div>
			</div>
			<div class="uk-width-medium-1-2 uk-width-xlarge-1-3">
				<div class="info-products-ozon-section">
					<h3><?= _l('YARARLARI') ?></h3>
					<?=$kutu2?>
				</div>
			</div>
			<div class="uk-width-medium-1-2 uk-width-xlarge-1-3">
				<div class="info-products-ozon-section">
					<h3><?= _l('TEKNİK ÖZELLİKLER') ?></h3>
					<?= str_replace('<table>','<table class="uk-table">',$kutu3) ?>					
				</div>
			</div>
        </div>
	</div>
</section>
