<?php

class Controller404 extends Controller {
	function actionIndex() {
		if ( isset($_GET['route']) ) {
			return $this->view->render('404', htmlspecialchars($_GET['route']));
		}

		return $this->view->render('404');
	}
}
