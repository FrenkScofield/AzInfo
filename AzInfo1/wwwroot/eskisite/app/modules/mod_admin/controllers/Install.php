<?php

class Install extends CController
{
	private $current_step = 0;
	
	public function _beforeAction($act=NULL)
	{
		$this->layout = 'install';
		if(!IS_LOCALHOST){
			CCoreHelper::show404();
		}
	}
	
	private function setAlert($alert)
	{
		$_SESSION['install_alert'] = $alert;
	}
	
	private function goBackError($error)
	{
		$this->setAlert($error);
		CUrlHelper::modRedirect('install/step'.($this->current_step -1));
	}
	
	public function actionIndex()
	{
		$this->actionStep1();
	}
		
	public function actionStep1()
	{
		$this->current_step = 1;
		
		$data = array(
			'modules'=>array()
		);
		
		$config = _getAppData('config');
		$modules = isset($config['main']['modules'])?$config['main']['modules']:array();
		//echo '<pre>'.print_r($modules,true).'</pre>';
		
		foreach($modules as $mod_alias=>$mod)
		{
			$data['modules'][] = array(
				'module'=>is_array($mod)?$mod['module']:$mod,
				'alias'=>is_array($mod)?$mod_alias:$mod,
			);
		}
		$this->render('step1',$data);		
	}
	
	public function actionStep2()
	{
		$model = new CModel();
		
		$db = & $model->_db;
		
		$this->current_step = 2;
		
		//debug($_POST);
		
		$module_selected = isset($_POST['module_selected'])&& is_array($_POST['module_selected']) ? $_POST['module_selected'] : array();
		
		if(count($module_selected)==0){
			$this->goBackError('No modules selected for installation!');
		}
		
		ob_start();
		foreach($module_selected as $mod=>$v)
		{
			if($mod=='mod_admin')
			{
				foreach(array('username','password','password2') as $k)
				{
					$name = 'mod_admin_'.$k;
					$$k = trim(CCoreHelper::getVal($_POST[$name]));
					if(empty($$k)){
						$this->goBackError($k.' input required');
					}
				}
				if($password!=$password2){
					$this->goBackError('Password repeat failed!');
				}
			}
			
			$install_sql = APP_PATH.'/modules/'.$mod.'/install.sql';
			if(is_file($install_sql))
			{
				echo file_get_contents($install_sql)."\n";
			}
			
			if($mod=='mod_admin')
			{
				$password = sha1($password);
?>
INSERT INTO `mod_admin_user` (`username`,`password`,`group_id`,`confirm_status`)
VALUES (
	'<?= $model->real_escape_string($username)?>',
	'<?= $model->real_escape_string($password)?>',
	'1',
	'1'
);

<?php 
			}			
		}
		
		$sql = ob_get_clean();
		//echo '<pre>'.$sql.'</pre>';
		?><pre><?php 
		ob_start();
		$q_arr = explode(";\n",$sql);				
		foreach($q_arr as $query){
			$query = trim($query);			
			if(!empty($query)){
				//echo $query."\n\n";
				$db->query($query);
			}
		}
		$errors = trim(ob_get_clean());
		?></pre>
		<?php 
		echo $errors;
		if(empty($errors))
		{
			?><h3>Modules installed!</h3><?php 
		}
		
	}
}













