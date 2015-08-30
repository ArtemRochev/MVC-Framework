<?php

require_once(PROJ_PATH . 'app/models/Comment.php');
require_once(PROJ_PATH . 'app/models/User.php');

class ControllerAdmin extends Controller {
	function actionIndex() {
		$this->checkAuth();
	}
	
	function actionShowPanel() {
		isset($_GET['part'])
			? $section = $_GET['part']
			: $section = 'index';

		$section .= PHP_EXT;

		//var_dump(VIEWS_PATH . 'admin/' . $section);
		//die();

		if ( !file_exists(VIEWS_PATH . 'admin/' . $section) ) {
			$this->redirect('404');
		}

		$this->view->render(
			'adminLayout.php',
			'admin/' . $section,
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
			'emptyLayout.php',
			'authPanel.php'
		);
	}
	
	function checkAuth() {
		isset($_POST['password'])
			? $pass = $_POST['password']
			: $pass = "";

		if ( $pass == '123' ) {
			return $this->redirect('admin?a=show-panel');
		} else {
			return $this->redirect('admin?a=show-login-panel');
		}
	}
}
