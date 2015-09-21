<?php

require_once(APP_PATH . 'models/Article.php');
require_once(APP_PATH . 'models/Comment.php');
require_once(APP_PATH . 'models/User.php');
require_once(APP_PATH . 'controllers/ControllerArticle.php');
require_once(CORE_PATH . 'base/ControllerAdmin.php');
require_once(TOOLS_PATH . 'Text.php');

class ControllerMain extends ControllerAdmin {
	function actionIndex() {
		if ( App::isAdmin() ) {
			Controller::redirect('admin/article');
		} else {
			Controller::redirect('/log-in');
		}
	}

	public function actionShowLoginPanel() {
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
}
