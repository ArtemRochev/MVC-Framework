<?php

class ControllerLogIn extends Controller {
    public function actionIndex() {
        $this->view->render('authPanel', [], 'user', 'empty');
    }
}
