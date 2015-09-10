<?php

require_once(APP_PATH . 'models/Article.php');
require_once(APP_PATH . 'models/Comment.php');
require_once(APP_PATH . 'models/User.php');
require_once(APP_PATH . 'controllers/ControllerArticle.php');
require_once(TOOLS_PATH . 'Text.php');

class ControllerAdmin extends Controller {
	const ACCESS_DENIED_MSG = 'Access denied';

	function actionIndex() {
		if ( App::isAdmin() ) {
			return Controller::redirect('admin/show-panel');
		} else {
			return Controller::redirect('admin/show-login-panel');
		}
	}
	
	function actionShowPanel() {
		if ( !App::isAdmin() ) {
			return $this->redirect('/admin');
		}

		$this->view->render(
			'index',
			'',
			'admin'
		);
	}

	function actionShowArticles() {
		if ( !App::isAdmin() ) {
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
		$success = false;

		if ( !empty($_POST['email']) && !empty($_POST['pass']) ) {
			$user = User::findOne(['email' => $_POST['email']]);

			if ( $_POST['pass'] === $user->pass ) {
				$user->token = Text::generateRandomString();
				$user->save();

				setcookie('user_id', $user->id, 0, '/');
				setcookie('token', $user->token, 0, '/');

				$success = true;
			}
		}

		if ( $success ) {
			return $this->redirect('/admin');
		}

		return $this->redirect('/admin/show-login-panel?error=Email or Password is incorrect');
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
			$article = Article::findById($_GET['id']);
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
