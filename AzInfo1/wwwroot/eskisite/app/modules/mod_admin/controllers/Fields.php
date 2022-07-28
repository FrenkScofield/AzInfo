<?php

class Fields extends CController
{
	
	public function _beforeAction($action=NULL)
	{		
		$this->layout = false;
		ModAdminUserHelper::requireLogin();
	}
	
	public function actionGetSlug(){
		if( isset($_POST['str']) )
		{
			echo CUrlHelper::getSlug($_POST['str']);
		}
	}
	
	public function actionTrigger_select_options()
	{
		if( isset($_POST['trigger_model']) && class_exists($_POST['trigger_model']) )
		{
			$class = $_POST['trigger_model'];
			$model = new $class ();
			if(isset($_POST['trigger_value']) && $model->findByPk($_POST['trigger_value']) )
			{
				if(isset($_POST['trigger_relation']) && isset($model->_relations[$_POST['trigger_relation']]))
				{
					?><option value="">-- <?=_mlang('Select','main','mod_admin')?> --</option><?php 
					$rel = $_POST['trigger_relation'];
					$model->$rel->run();
					while($model->$rel->fetchRow())
					{
						?><option value="<?=$model->$rel->getId()?>"><?=$model->$rel->getLabel()?></option><?php 
					}
				}
			}
		}
	}
}
