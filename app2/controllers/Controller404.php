<?php

class Controller404 extends Controller {
	function actionIndex() {
		echo 404 . '<br>' . $_GET['msg'];
	}
}
