<?php

require 'recaptcha-php-1.11/recaptchalib.php';

class Plugin_Recaptcha
{
	public $publickey  = '6LdU3AkAAAAAAPxz_h691guv1_WMzhC-t0jG3Ygk';
	public $privatekey = '6LdU3AkAAAAAAJ53JFX1AMkQEXUP9o01O-9hn-g5';
	
	public $options = array(
		'theme'=>'clean',
		'lang'=>LANG,
	);
	
	// used as getHtml method parameters
	public $error = null;
	public $use_ssl = false;
	
	public function __construct() {
		if( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ){
			$this->use_ssl = true;
		}
	}
	
	
	public function get_options_script(){
		ob_start();
		?>
		<script type="text/javascript">
			var RecaptchaOptions = <?=  json_encode($this->options)?>;
		</script>
		<?php 
		return ob_get_clean();
	}
	
	public function getHtml($publickey = '')
	{
		if(empty($publickey))
		{
			$publickey = $this->publickey;
		}		
		return  $this->get_options_script() . recaptcha_get_html($publickey,$this->error,$this->use_ssl);
	}
	
	public function getCustomHtml($publickey = '')
	{
		if(empty($publickey))
		{
			$publickey = $this->publickey;
		}
		ob_start();
		?>
		<script>
		var RecaptchaOptions = {
		   theme: 'custom',
		   lang: 'en',
		   custom_theme_widget: 'recaptcha_widget'
		};
		</script>		
		<div id="recaptcha_widget" style="display:none">
			<div id="recaptcha_image"></div>			
			<?php /*
			<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>
			<span class="recaptcha_only_if_image">Enter the words above:</span>
			<span class="recaptcha_only_if_audio">Enter the numbers you hear:</span>
			*/?>
			<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" style="margin-top:5px;">
			<?php /*
			<div><a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a></div>
			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
			<div><a href="javascript:Recaptcha.showhelp()">Help</a>
			*/?>			
		</div>
		<script type="text/javascript" src="http://api.recaptcha.net/challenge?k=<?=$publickey?>&lang=en"></script>
		<noscript>
		  <iframe src="http://api.recaptcha.net/noscript?k=<?=$publickey?>&lang=en" height="300" width="500" frameborder="0"></iframe><br />
		  <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
		  <input type='hidden' name='recaptcha_response_field' value='manual_challenge'>
		</noscript>
		<?php 
		return ob_get_clean();
	}
	
	
	
	public function validate($privatekey = '')
	{
		if(empty($privatekey))
		{
			$privatekey = $this->privatekey;
		}
		
		isset($_POST['recaptcha_challenge_field']) || ($_POST['recaptcha_challenge_field']='');
		isset($_POST['recaptcha_response_field']) || ($_POST['recaptcha_response_field']='');
		
		$resp = recaptcha_check_answer ($privatekey,
			$_SERVER['REMOTE_ADDR'],
			$_POST['recaptcha_challenge_field'],
			$_POST['recaptcha_response_field']
		);

		if ($resp->is_valid)
		{
			return true;
		}
		else
		{
			$this->error =  $resp->error;
			return false;
		}		
	}
	
	
	public function getMailhideHtml($email)
	{
		return recaptcha_mailhide_html ('01NnvkxLRoeKlEO6Y48NM0_w==','D17D8E7BD4D72EE9450D2C520C290059', $email);
	}
	
	public function getMailhideUrl($email)
	{
		return recaptcha_mailhide_url ('01NnvkxLRoeKlEO6Y48NM0_w==','D17D8E7BD4D72EE9450D2C520C290059', $email);
	}
}
