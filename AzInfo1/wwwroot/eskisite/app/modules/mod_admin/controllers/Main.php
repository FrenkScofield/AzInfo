<?php

class Main extends CController
{
	
	public function _beforeAction($action = NULL)
	{		
		if(isset($_GET['xhr'])){
			$this->layout = false;
			$this->isXhr = true;
		}
	}
	
	public function actionIndex()
	{		
		ModAdminUserHelper::requireLogin();
		if(is_file(APP_PATH.'/admin/custom/home.php')){
			$this->_view_dir = '../../../admin/custom';
		}
		$this->render('home');
	}
	
	public function actionPing()
	{
		header('Content-type:text/javascript;charset=utf-8',true);
		
		ModAdminUserHelper::initToken();
		
		$data = array(
			'token'=>$_SESSION['mod_admin_token'],
			'logged_in'=>ModAdminUserHelper::isLoggedIn(),
			'username'=>isset($_SESSION['mod_admin']['user']['username'])?$_SESSION['mod_admin']['user']['username']:'',
		);
		echo json_encode($data);
		return;
	}
	
	
	public function actionAdmin_menu()
	{
		ModAdminMenuHelper::showMainMenu();
	}
	
	
	public function actionTemplate_list()
	{
		header('Content-type:text/javascript;charset=utf-8',true);
				
		if(! ModAdminUserHelper::isLoggedIn())
		{
			?>var tinyMCETemplateList = new Array();<?php 
			return;
		}		
		$files = array();
		
		$model = new ModAdminEmailTemplateModel();
		foreach($model->orderBy('`order` ASC')->findAll() as $row){
			$files[] = array(
				'name'=>$row->title,
				'file'=>CUrlHelper::getModXUrl('mod_admin','main/template_file',array('id'=>$row->template_id))
			);
		}
				
		?>
var tinyMCETemplateList = new Array(
<?php 				
		foreach($files as $i=>$tmp){
			if($i!=0) echo ',';
			?>	["<?=$tmp['name']?>", "<?=$tmp['file']?>"]<?php 
		}
		?>
		
);
		<?php 
	}
	
	public function actionTemplate_file()
	{
		header('Content-type:text/html;charset=utf-8',true);
		if(! ModAdminUserHelper::isLoggedIn())
		{			
			return;
		}
		
		if($id=CCoreHelper::getIdParam('id'))
		{
			$model = new ModAdminEmailTemplateModel();
			if($model->findByPk($id))
				echo  html_entity_decode($model->content);
		}
	}	
}
