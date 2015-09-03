<?php

abstract class Controller {
	public $model;
	public $view;

	public function __construct() {
		$this->view = new View();
	}

	public static function redirect($route) {
		header('Location: ' . $route);
	}

	public static function redirectTo404($route = '') {
		header("HTTP/1.0 404 Not Found");
		header('Location: 404?route=' . $route);
	}
}
