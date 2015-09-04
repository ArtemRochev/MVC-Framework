<?php

require_once(PROJ_PATH . 'app/models/User.php');
require_once(PROJ_PATH . 'app/models/Article.php');
require_once(PROJ_PATH . 'app/models/Comment.php');

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
	
	public function actionShowArticle() {
		if ( !$_GET['id'] ) {
			return Controller::redirectTo404($_SERVER['REQUEST_URI']);
		}

		if ( !$article = Article::findOne($_GET['id']) ) {
			return Controller::redirectTo404($_SERVER['REQUEST_URI']);
		}

		$comments = $article->getComments();

		return $this->view->render('showArticle', [
			'article' => $article,
			'commentsCount' => count($comments),
			'comments' => $comments
		]);
	}

	public static function saveArticle($params) {
		$article = new Article;

		if ( $article->checkRequiredColumns($params) ) {
			$article->author_id = 1;
			$article->title = $params['title'];
			$article->content = $params['content'];
			$article->img_preview_url = $params['img_preview_url'];

			$article->save();
		}
	}

	public static function deleteArticle($id) {
		if ( isset($id) ) {
			$article = new Article($id);
			$article->delete();
		}
	}
}
