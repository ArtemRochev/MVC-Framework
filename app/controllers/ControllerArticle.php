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
		$url = end(App::parseRoute($_SERVER['REQUEST_URI'])['routes']);
		$article = Article::findOne([
			'url_crc' => crc32($url)
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

		Comment::saveComment($_POST, true);
		//$this->redirect(Url::to('/article/show/' . $_POST['article_id']));
	}

	public function actionDeleteComment() {
		if ( empty($_POST['id']) || !App::isAdmin() ) {
			return $this->redirect('/article');
		}

		$currentArticleUrl = Article::findById(Comment::findById($_POST['id'])->article_id)->url;
		Comment::deleteComment($_POST['id']);
		$this->redirect('/article/show/' . $currentArticleUrl);
	}

	public static function delete($id) {
		Article::deleteArticle($id);
	}
}
