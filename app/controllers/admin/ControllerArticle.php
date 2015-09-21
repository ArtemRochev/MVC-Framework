<?php

require_once(CORE_PATH . 'base/ControllerAdmin.php');
require_once(APP_PATH . 'controllers/ControllerArticle.php');
require_once(APP_PATH . 'models/Article.php');

class ControllerArticle extends ControllerAdmin {
    public function actionIndex() {
        $this->view->render(
            'articles',
            Article::all()
        );
    }

    public function actionModify() {
        $article;

        if ( isset($_GET['id']) ) {
            $article = Article::findById($_GET['id']);
        } else {
            $article = new Article; //fix
            $article->title = '';
            $article->content = '';
            $article->img_preview_url = '';
            $article->author_id = 1;
            $article->save();
        }

        $this->view->render('modifyArticle', ['article' => $article], 'admin');
    }

    public function actionSave() {
        ControllerArticle::saveArticle($_POST);

        return Controller::redirect('/admin/show-articles');
    }

    public function actionDelete() {
        ControllerArticle::deleteArticle($_GET['id']);

        return Controller::redirect('/admin/show-articles');
    }
}
