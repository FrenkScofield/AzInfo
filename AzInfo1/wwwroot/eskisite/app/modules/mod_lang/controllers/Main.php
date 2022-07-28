<?php 

class Main extends CController
{
	public function actionIndex()
	{
		CUrlHelper::redirect('main/index');
	}
}
