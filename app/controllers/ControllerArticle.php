<?php

require_once(CORE_PATH . 'base/App.php');
require_once(APP_PATH . 'models/User.php');
require_once(APP_PATH . 'models/Article.php');
require_once(APP_PATH . 'models/Comment.php');

class ControllerArticle extends Controller {
	function __construct() {
		Controller::__construct();
	}
	
	public function actionIndex() {
		$this->view->render(
			'articles',
			Article::all()
		);
	}
	
	public function actionShow() {
		$urlHash = md5(end(App::parseRoute($_SERVER['REQUEST_URI'])['routes']));
		$article = Article::findOne([
			'url_md5' => $urlHash
		]);

		if ( empty($article) && !article ) {
			return Controller::redirectTo404($_SERVER['REQUEST_URI']);
		}

		$comments = $article->getComments();

		return $this->view->render('showArticle', [
			'article' => $article,
			'commentsCount' => count($comments),
			'comments' => $comments
		]);
	}

	public function actionSaveComment() {
		if ( !isset($_POST['article_id']) ) {
			return $this->redirect('/article');
		}

		Comment::saveComment($_POST);
		$this->redirect(Url::to('/article/article', ['id' => $_POST['article_id']]));
	}

	public function actionDeleteComment() {
		if ( empty($_POST['id']) ) {
			return $this->redirect('/article');
		}

		Comment::deleteComment($_POST['id']);
		$this->redirect('/article');
	}

	public static function delete($id) {
		Article::deleteArticle($id);
	}
}
