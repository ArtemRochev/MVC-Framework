<?php

class View {
	function render($viewName, $contentView = 'main.php', $data = null) {
		include(VIEWS_PATH . 'layout/' . $viewName);
	}
}
