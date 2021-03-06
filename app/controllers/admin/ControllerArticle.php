<?php

require_once(CORE_PATH . 'base/ControllerAdmin.php');
require_once(APP_PATH . 'models/Article.php');

class ControllerArticle extends ControllerAdmin {
    public function actionIndex() {
        $this->view->render(
            'articles',
            Article::all()
        );
    }

    public function actionShowArticles() {
        return Controller::redirect('/admin');
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
        Article::saveArticle($_POST);

        return Controller::redirect('/admin/article');
    }

    public function actionDelete() {
        Article::deleteArticle($_GET['id']);

        return Controller::redirect('/admin/article');
    }
}
