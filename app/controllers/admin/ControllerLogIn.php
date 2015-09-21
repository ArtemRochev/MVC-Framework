<?php

require_once(CORE_PATH . 'base/ControllerAdmin.php');

class ControllerLogIn extends ControllerAdmin {
    public function actionIndex() {
        $this->view->render('main');
    }
}
