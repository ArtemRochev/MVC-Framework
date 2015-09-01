<?php

class View {
	function render($viewName, $contentView = 'main', $data = null) {
		$contentView .= PHP_EXT;

		include(VIEWS_PATH . 'layout/' . $viewName . PHP_EXT);
	}
}
