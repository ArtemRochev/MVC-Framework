<?php

require_once(PROJ_PATH . 'app/models/Article.php');
require_once(PROJ_PATH . 'app/models/Comment.php');
require_once(PROJ_PATH . 'app/models/User.php');
require_once(PROJ_PATH . 'app/controllers/ControllerArticle.php');
require_once(CORE_PATH . 'tools/Text.php');

class ControllerAdmin extends Controller {
	function actionIndex() {
		if ( Router::isAdmin() ) {
			return Controller::redirect('admin/show-panel');
		} else {
			return Controller::redirect('admin/show-login-panel');
		}
	}
	
	function actionShowPanel() {
		if ( !Router::isAdmin() ) {
			return $this->redirect('/admin');
		}

		$this->view->render(
			'index',
			'',
			'admin'
		);
	}

	function actionShowArticles() {
		if ( !Router::isAdmin() ) {
			return $this->redirect('/admin');
		}

		$this->view->render(
			'articles',
			Article::all(),
			'admin'
		);
	}
	
	function actionShowLoginPanel() {
		$this->view->render(
			'authPanel',
			[],
			'user',
			'empty'
		);

		isset($_POST['email'])
			? $pass = $_POST['email']
			: $pass = '';
	}
	
	function checkAuth() {

	}

	public function actionLogIn() {
		if ( !empty($_POST['email']) && !empty($_POST['pass']) ) {
			$user = User::findOneWhere(['email' => $_POST['email']]);

			if ( $_POST['pass'] === $user->pass ) {
				$user->token = Text::generateRandomString();
				$user->save();

				setcookie('user_id', $user->id);
				setcookie('token', $user->token);
			}
		}

		$this->redirect('/admin');
	}

	public function actionSaveArticle() {
		ControllerArticle::saveArticle($_POST);

		return Controller::redirect('/admin/show-articles');
	}

	public function actionDeleteArticle() {
		ControllerArticle::deleteArticle($_GET['id']);

		return Controller::redirect('/admin/show-articles');
	}

	public function actionModifyArticle() {
		$article;

		if ( isset($_GET['id']) ) {
			$article = Article::findOne($_GET['id']);
		} else {
			$article = new Article; //fix
			$article->title = '';
			$article->content = '';
			$article->img_preview_url = '';
			$article->author_id = 1;
			$article->save();
		}

		$this->view->render('modifyArticle', ['article' => $article], 'admin');
	}
}
