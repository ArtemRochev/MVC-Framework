<?php

require_once(PROJ_PATH . 'app/models/Article.php');
require_once(PROJ_PATH . 'app/models/Comment.php');
require_once(PROJ_PATH . 'app/models/User.php');

class ControllerAdmin extends Controller {
	function actionIndex() {
		$this->checkAuth();
	}
	
	function actionShowPanel() {
		$this->view->render(
			'adminLayout.php'
		);
	}

	function actionShowArticles() {
		$this->view->render(
			'adminLayout.php',
			'admin/articles.php',
			Article::getArticles()
		);
	}

	function actionShowComments() {
		$this->view->render(
			'adminLayout.php',
			'admin/comments.php',
			Comment::getComments()
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

	public function actionSaveArticle() {
		$article = new Article;

		$article->author_id = $_POST['author_id'];
		$article->title = $_POST['title'];
		$article->content = $_POST['content'];

		$article->save();

		return $this->redirect('/admin?a=show-articles');
	}

	public function actionDeleteArticle() {
		$article = new Article($_POST['id']);
		var_dump($article);
		//die();
		$article->delete();

		return $this->redirect('/admin?a=show-articles');
	}
}
