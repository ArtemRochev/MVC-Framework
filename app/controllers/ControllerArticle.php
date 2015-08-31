<?php

require_once(PROJ_PATH . 'app/models/User.php');
require_once(PROJ_PATH . 'app/models/Article.php');

class ControllerArticle extends Controller {
	function __construct() {
		Controller::__construct();
	}
	
	public function actionIndex() {
		$this->view->render(
			'mainLayout',
			'articles',
			Article::getArticles()
		);
	}
	
	public function actionShowArticle() {
		if ( !$_GET['id'] ) {
			return Controller::redirectTo404($_SERVER['REQUEST_URI']);
		}

		if ( $article = Article::getArticle($_GET['id']) ) {
			return $this->view->render('mainLayout', 'showArticle', $article);
		}

		return Controller::redirectTo404($_SERVER['REQUEST_URI']);
	}
}
