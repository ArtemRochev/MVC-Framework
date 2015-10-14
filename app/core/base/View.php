<?php

require_once(CORE_PATH . 'tools/Url.php');

class View {
	protected $forAdmin = false;

	public function __construct($forAdmin = false) {
		$this->forAdmin = $forAdmin;
	}

	public function render($view = 'index', $data = null, $theme = 'user', $layout = 'main') {
		if ( $this->forAdmin && !App::isAdmin() ) {
			return Controller::redirect('/admin');
		}

		if ( $this->forAdmin ) {
			$theme = 'admin';
			$layout = 'admin';
		}

		$view 	= VIEWS_PATH . $theme . '/' . $view . PHP_EXT;
		$layout = VIEWS_PATH . 'layout/' . $layout . PHP_EXT;



		include($layout);
	}

	public function includeTemplate($template, $data = [], $theme = 'user') {
		_debug(Html::tag('p', '[TPL+ ' . $template . ']'));
		include(VIEWS_PATH . "/$theme/$template");
		_debug(Html::tag('p', '[TPL- ' . $template . ']'));
	}
}
