<?php

class ControllerMain extends Controller {
	public function actionIndex() {
		$this->view->renderPublic('main');
	}

	public function actionShowLoginPanel() {
		$this->view->renderPublic(
			'authPanel',
			[],
			'user',
			'empty'
		);

		isset($_POST['email'])
			? $pass = $_POST['email']
			: $pass = '';
	}
}
