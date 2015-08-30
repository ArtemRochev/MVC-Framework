<?php

class View {
	function render($viewName, $contentView = 'main.php', $data = null) {
		include(PROJ_PATH . 'app/views/layout/' . $viewName);
	}
}
