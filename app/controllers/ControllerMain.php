<?php

class ControllerMain extends Controller {
	function actionIndex() {
		$this->view->render('mainLayout.php');
	}
}
