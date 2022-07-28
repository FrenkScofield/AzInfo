<section class="info-company">
    <div class="uk-container uk-container-center">
        <div class="uk-grid"> 
			<div class="uk-width-large-1-1">
				<?php 
				$n = count($rows);
				if ($n == 0) {
					?><div class="error"><?= _l('Aramanıza uygun sonuç bulunamadı.') ?></div><?php 
				} else {
					?><ol class="search_results"><?php 
					foreach ($rows as $row) {
						?><li><a href="<?= $row['href'] ?>"><?= $row['title'] ?></a></li><?php 
						}
						?></ol><?php 
				}
				?>
			</div>			
        </div>
    </div>
</section>