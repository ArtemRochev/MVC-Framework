<?php

require_once(PROJ_PATH . 'app/models/User.php');
require_once(PROJ_PATH . 'app/models/Article.php');

class ControllerArticle extends Controller {
	function __construct() {
		Controller::__construct();
	}
	
	function actionIndex() {
		$this->view->render(
			'mainLayout.php',
			'articles.php',
			Article::getArticles()
		);
	}
	
	function actionSave() {
		//echo "Name: " . $_POST['name'] . "<br>";
		//echo "Name: " . $_POST['email'] . "<br>";
		//echo "Name: " . $_POST['text'] . "<br>";
		
		$userId = 0;
		
//		if ( !User::checkUserExists($_POST['email']) ) {
//			$userId = $this->modelUsers->addUser($_POST['name'], $_POST['email']);
//		} else {
//			$userId = User::getRecordDataByField("user", "email", $_POST['email'])['user_id'];
//		}

		Comment::saveComment(1);

		$this->redirect('/comments');
	}
}
