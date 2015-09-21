<?php

class ControllerMain extends Controller {
	public function actionIndex() {
		$this->view->render('main');
	}
}
