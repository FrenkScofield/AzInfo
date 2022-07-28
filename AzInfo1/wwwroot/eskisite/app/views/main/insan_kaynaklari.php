<section class="info-human-resources">
	<div class="uk-container uk-container-center">
        <div class="uk-grid">
			<div class="uk-width-1-1">
				
				<?=$yazi?>
				
			</div>
			
			<div class="uk-width-large-1-1">
				<div class="info-human-form">
					<h2><?= _l('İNSAN KAYNAKLARI FORMU') ?></h2>
					<?php
					$form->showErrors();
					if($result){
						$form = new IkForm();
					}
					?>
					<form class="uk-form" action="<?=CUrlHelper::getUrl('main/insan_kaynaklari')?>" method="post" enctype="multipart/form-data">
						<?= $form->getTokenInput(); ?>
						<?= $form->getFillScript(); ?>
						
						<div class="uk-grid uk-grid-small">
							<div class="uk-width-large-1-2">
								<div class="uk-form-row">
									<input type="text" name="isim" placeholder="<?= _l('Adınız  Soyadınız') ?>">
								</div>
								<div class="uk-form-row">
									<input type="email" name="email" placeholder="<?= _l('E-mail Adresiniz') ?>">
								</div>
								<div class="uk-form-row">
									<input type="tel"  name="telefon" placeholder="<?= _l('Telefon Numaranız') ?>">
								</div>
								<div class="uk-form-row uk-position-relative">
									<div class="file-upload-wrapper">
										<input class="custom-file-upload-hidden" id="file" name="file" style="position: absolute; left: -9999px;" tabindex="-1" type="file">
									</div>
								</div>
							</div>
							<div class="uk-width-large-1-2">
								<textarea name="mesaj" placeholder="<?= _l('Mesajınız') ?>"></textarea>
								<button><?= _l('GÖNDER') ?></button>
							</div>
						</div>
					</form>
					
				</div>
			</div>
        </div>
	</div>
</section>
