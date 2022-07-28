<?php 

class EmailHelper extends CHelper
{
	// Ayarları ekrana yazdırarak gönderim testi yapmak için
	public static function sendDebug($to,$subject,$message,$replyTo=null,$attachment=null){
		return self::send($to,$subject,$message,$replyTo,$attachment,true);
	}
	
		
	public static function send($to,$subject,$message,$replyTo=null,$attachment=null,$debug=false)
	{
		$phpmailer = new Plugin_Phpmailer($debug);
		
		if($debug){
			$phpmailer->SMTPDebug = 1;
		}
		
		$phpmailer->CharSet = 'utf-8';
		
		$mail_host = ModSiteHelper::get_ayar('mail_host');
		$mail_port = ModSiteHelper::get_ayar('mail_port');
		$mail_username = ModSiteHelper::get_ayar('mail_username');
		$mail_password = ModSiteHelper::get_ayar('mail_password');
		
		if(empty($mail_port)){
			$mail_port = 587;
		}
		
		if(!empty($mail_host)){
			$phpmailer->IsSMTP();
			$phpmailer->SMTPAuth = true;
			$phpmailer->Host       = $mail_host;
			$phpmailer->Port       = $mail_port;
			
			$phpmailer->Username   = $mail_username;
			$phpmailer->Password   = $mail_password;
			
			if($debug){
				echo 'Host: '.$phpmailer->Host .'<br>';
				echo 'Port: '.$phpmailer->Port .'<br>';				
				echo 'Username: '.$phpmailer->Username .'<br>';
				echo 'Password: '.$phpmailer->Password .'<br>';
			}	
			
		}		
		
		is_array($to) || $to = array($to);
		foreach($to as $add)
		{
			$phpmailer->AddAddress($add);
			if($debug){
				echo 'AddAddress: '.$add .'<br>';
			}
		}
		
		if(_getAppData('is_localhost'))
		{
			$domain = 'example.com';
		}
		else
		{
			$host = $_SERVER['HTTP_HOST'];
			$domain = preg_replace('/^(www.)/','',$host);
		}
		
		$config = _getAppData('config',true);
		$sitename=$config['main']['defaultTitle'];
				
		if(CValidateHelper::email($mail_username)){
			$phpmailer->SetFrom($mail_username,$sitename);
			if($debug){
				echo 'SetFrom: '.$mail_username.','.$sitename .'<br>';
			}
		}
		else {
			$muser = explode('@',$mail_username);
			$muser = $muser[0];
			$phpmailer->SetFrom($muser.'@'.$domain,$sitename);
			if($debug){
				echo 'SetFrom: '.$muser.'@'.$domain.','.$sitename .'<br>';
			}
		}
		
		
		if($replyTo!==null)
		{
			$phpmailer->ClearReplyTos();
			is_array($replyTo) || $replyTo = array($replyTo);
			if(isset($replyTo[1]))
			{
				$phpmailer->AddReplyTo($replyTo[0],$replyTo[1]);
			}
			else
			{
				$phpmailer->AddReplyTo($replyTo[0]);
			}
		}
		
		if($attachment!==null)
		{
			if(is_array($attachment)){ // çoklu dosya eki varsa hepsini ekle
				foreach($attachment as $file){
					$phpmailer->AddAttachment($file);
				}
			}
			else {
				$phpmailer->AddAttachment($attachment);
			}
		}
				
		$phpmailer->Subject =$subject;
		$phpmailer->MsgHTML($message);
		$return =  $phpmailer->Send();
		if(!$return){
			file_put_contents(APP_PATH.'/log/mailer.log', date('Y-m-d H:i:s') .' '.$phpmailer->ErrorInfo);
		}
		return $return;
	}
}
