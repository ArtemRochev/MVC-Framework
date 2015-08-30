<?php

require_once(PROJ_PATH . 'app/models/Comment.php');
require_once(PROJ_PATH . 'app/models/User.php');

class ControllerAdmin extends Controller {
	function actionIndex() {
		$this->checkAuth();
	}
	
	function actionShowAdminPanel() {
		$this->view->render(
			'mainAdmin.php',
			'admin.php',
			Comment::getComments()
		);
	}
	
	function actionEdit() {
		$this->view->generateView(
			'templateAdmin.php',
			'comments.php',
			$this->modelComments->getComments(true)
		);
	}
	
	function actionShowLoginPanel() {
		$this->view->render(
			'empty.php',
			'authPanel.php'
		);
	}
	
	function checkAuth() {
		isset($_POST['password'])
			? $pass = $_POST['password']
			: $pass = "";

		if ( $pass == '123' ) {
			return $this->redirect('admin?a=show-admin-panel');
		} else {
			return $this->redirect('admin?a=show-login-panel');
		}
	}
}
