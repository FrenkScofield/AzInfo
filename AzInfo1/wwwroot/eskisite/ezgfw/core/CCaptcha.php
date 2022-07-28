<?php

class CCaptcha {
	
	public $imgpath = '';
	
    public function generateCode($digits) {
		$chars = "abcdefghjkmnprstuxvyz23456789ABCDEFGHJKMNPRSTUXVYZ";
		$return = '';
		for($i=0;$i<$digits;$i++) {
			$return .= $chars{rand(0,48)};
		}
		return $return; 
	}
	
	public function getImage(){
		
		$font = FW_PATH.'/fonts/AHGBold.ttf'; 
		$width = "75";
		$height = "20";
		$hane = "5";

		$metin = $this->generateCode($hane);

		// Arkaplan resmini oluşturuyoruz
		$resim_yaz=imagecreate($width,$height);
		imagecolorallocate($resim_yaz, 255, 255, 255);

		// Metin rengi ve karışıklık yaratmasını istediğimiz diğer renklerini tanımlıyoruz.
		$text_renk = imagecolorallocate($resim_yaz, 29, 96, 146);
		$bg1 = imagecolorallocate($resim_yaz, 244, 244, 244);
		$bg2 = imagecolorallocate($resim_yaz, 227, 239, 253);
		$bg3 = imagecolorallocate($resim_yaz, 207, 244, 204);

		header('Content-type: image/png');
		imagettftext($resim_yaz, 26, -4, 4, 25, $bg1, $font, $metin);
		imagettftext($resim_yaz, 30, -7, 0, 15, $bg2, $font, $metin);

		// Arka plana rastgele çizgiler yazdırıyoruz.
		for( $i=0; $i<($width*$height)/400; $i++ ) {
			imageline($resim_yaz, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $bg3);
		}

		// Metnimizi (güvenlik kodu) bastırıyoruz.
		imagettftext($resim_yaz, 14, 3, 7, 17, $text_renk, $font, $metin);
		imagepng($resim_yaz);
		imagedestroy($resim_yaz);

		// Session değerlerini atıyoruz.
		$_SESSION['captcha'] = "$metin";
	}
	
	public function imgHtml($width='',$height=''){
		$imgpath = $this->imgpath;
		if(empty($imgpath)){
			$imgpath = BASE_URL.'/captcha.php';
		}
		?><img src="<?=$imgpath?>?u=<?= uniqid()?>" <?=(!empty($width)?'width="'.$width.'"':'')?> <?=(!empty($height)?'height="'.$height.'"':'')?> /><?php 
	}
	
}
