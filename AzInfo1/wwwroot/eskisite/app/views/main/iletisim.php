<section class="info-contact">
	<div class="uk-container uk-container-center">    
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBavN3zyKuzb6gILPAR4qj3d-CYXQWUaws&amp;"></script>
		<div class="uk-grid">
		<?php foreach($adresler as $i=>$adres){
			$mapid = $i+1;
			?>	
			<div class="uk-width-large-1-2">
				<h3><?=$adres['baslik']?></h3>
				<ul>
					<li><span><?= _l('Adres') ?></span><?=$adres['adres']?></li>
					<li><span><?= _l('Telefon') ?></span><a href="tel:<?= str_replace(array('(',')',' '), '', $adres['telefon'])?>"><?=$adres['telefon']?></a></li>
					<li><span><?= _l('Faks') ?></span><a href="tel:<?= str_replace(array('(',')',' '), '', $adres['faks'])?>"><?=$adres['faks']?></a></li>
					<li><span><?= _l('E-mail') ?></span><a href="mailto:info@infogroup.com.tr"><?=$adres['email']?></a></li>
					<li><span><?= _l('Yol Tarifi') ?></span><a href="<?=$adres['harita_link']?>" target="_blank"><?=$adres['enlem']?>, <?=$adres['boylam']?></a></li>
				</ul>
				<div class="info-map-<?=$mapid?>">					
					<div id="info-map-<?=$mapid?>"> </div>
					<script type="text/javascript">
						var myLatlng<?=$mapid?> = new google.maps.LatLng(<?=$adres['enlem']?>, <?=$adres['boylam']?>);

						var map<?=$mapid?> = new google.maps.Map(document.getElementById("info-map-<?=$mapid?>"), {

							mapTypeId: google.maps.MapTypeId.ROADMAP,
							center: myLatlng<?=$mapid?>,
							scrollwheel: false,
							zoomControl: true,
							zoom: 15

						});

						var marker<?=$mapid?> = new google.maps.Marker({

							map: map<?=$mapid?>,
							icon: '<?= BASE_URL .'/' ?>images/contact/map-marker.png',
							position: myLatlng<?=$mapid?>

						});
					</script>
				</div>
			</div>
		<?php } ?>
        </div>
	</div>
</section>
