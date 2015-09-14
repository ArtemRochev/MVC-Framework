<?php

require_once(CORE_PATH . 'tools/Url.php');

class View {
	public function renderPublic($view = 'index', $data = null, $theme = 'user', $layout = 'main') {
		if ( $theme == 'admin' ) {
			$layout = 'admin';
		}

		$view 	= VIEWS_PATH . $theme . '/' . $view . PHP_EXT;
		$layout = VIEWS_PATH . 'layout/' . $layout . PHP_EXT;

		include($layout);
	}

	public function renderAdmin($view = 'index', $data = null, $theme = 'user', $layout = 'main') {
		if ( !App::isAdmin() ) {
			return Controller::redirect('/admin');
		}

		if ( $theme == 'admin' ) {
			$layout = 'admin';
		}

		$view 	= VIEWS_PATH . $theme . '/' . $view . PHP_EXT;
		$layout = VIEWS_PATH . 'layout/' . $layout . PHP_EXT;

		include($layout);
	}

	public function includeTemplate($template, $data = '') {
		include(VIEWS_PATH . $template);
	}
}
