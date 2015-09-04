<?php

require_once(PROJ_PATH . 'app/models/Article.php');
require_once(PROJ_PATH . 'app/models/Comment.php');
require_once(PROJ_PATH . 'app/models/User.php');

require_once(PROJ_PATH . 'app/controllers/ControllerArticle.php');

class ControllerAdmin extends Controller {
	function actionIndex() {
		$this->checkAuth();
	}
	
	function actionShowPanel() {
		$this->view->render(
			'index',
			'',
			'admin'
		);
	}

	function actionShowArticles() {
		$this->view->render(
			'articles',
			Article::getArticles(),
			'admin'
		);
	}

	function actionShowComments() {
		$this->view->render(
			'adminLayout',
			'admin/comments',
			Comment::getComments()
		);
	}
	
	function actionShowLoginPanel() {
		$this->view->render(
			'authPanel',
			'',
			'user',
			'empty'
		);
	}
	
	function checkAuth() {
		isset($_POST['password'])
			? $pass = $_POST['password']
			: $pass = '';

		if ( $pass === '123' ) {
			return Controller::redirect('admin/show-panel');
		} else {
			return Controller::redirect('admin/show-login-panel');
		}
	}

	public function actionModifyArticle() {
		$this->view->render('modifyArticle', '', 'admin');

		//ControllerArticle::saveArticle($_POST);
	}

	public function actionSaveArticle() {
		ControllerArticle::saveArticle($_POST);
	}

	public function actionDeleteArticle() {
		//die('g');
		ControllerArticle::deleteArticle($_POST['id']);
	}
}
