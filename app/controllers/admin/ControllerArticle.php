<?php

require_once(CORE_PATH . 'base/ControllerAdmin.php');
require_once(APP_PATH . 'models/Article.php');

class ControllerArticle extends ControllerAdmin {
    function actionIndex() {
        $this->view->renderAdmin(
            'articles',
            Article::all(),
            'admin'
        );
    }
}
