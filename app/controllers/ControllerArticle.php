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

		if ( !$article = Article::findById($_GET['id']) ) {
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

		$comment = new Comment();

		$comment->author_id = $_POST['author_id'];
		$comment->article_id = $_POST['article_id'];
		$comment->text = $_POST['text'];
		$comment->save();

		$this->redirect(Url::to('/article/show-article', ['id' => $_POST['article_id']]));
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
