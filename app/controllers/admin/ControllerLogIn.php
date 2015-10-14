<?php

require_once(CORE_PATH . 'base/ControllerAdmin.php');

class ControllerLogIn extends ControllerAdmin {
    public function actionIndex() {
        $this->logIn();
    }

    private function logIn() {
        $success = false;

        if ( !empty($_POST['email']) && !empty($_POST['pass']) ) {
            $user = User::findOne(['email' => $_POST['email']]);

            if ( $_POST['pass'] === $user->pass ) {
                $user->token = Text::generateRandomString();
                $user->save();

                setcookie('user_id', $user->id, 0, '/');
                setcookie('token', $user->token, 0, '/');

                $success = true;
            }
        }

        if ( $success ) {
            return $this->redirect('/admin');
        }

        return $this->redirect('/log-in?error=1');
    }
}
