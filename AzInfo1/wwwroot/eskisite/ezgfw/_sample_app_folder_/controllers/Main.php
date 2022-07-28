<?php

class Main extends CController
{

	public function _beforeAction($action=null) {
		
	}
	
	public function actionIndex() {		
		$this->render('anasayfa');
	}
}
