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
			'adminLayout'
		);
	}

	function actionShowArticles() {
		$this->view->render(
			'adminLayout',
			'admin/articles',
			Article::getArticles()
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
			'emptyLayout',
			'authPanel'
		);
	}
	
	function checkAuth() {
		isset($_POST['password'])
			? $pass = $_POST['password']
			: $pass = "";

		if ( $pass == '123' ) {
			return Controller::redirect('admin?a=show-panel');
		} else {
			return Controller::redirect('admin?a=show-login-panel');
		}
	}

	public function actionSaveArticle() {
		//var_dump($_POST);
		//die();
		ControllerArticle::saveArticle($_POST);
	}

	public function actionDeleteArticle() {
		$article = new Article($_POST['id']);
		$article->delete();

		return Controller::redirect('/admin?a=show-articles');
	}
}
