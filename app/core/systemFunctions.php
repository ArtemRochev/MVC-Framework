<?php

function _debug($msg, $args = null, $stopScript = false){
    if ( !empty($_GET['debug']) && $_COOKIE['user_id'] == 1 ) {
        $msg = "<p style=\"font-size:13;color:rgb(22, 64, 72)\">$msg</p>";

        if ( $args ) {
            echo vsprintf(str_replace('?', '%s', $msg), $args);
        } else {
            echo $msg;
        }
        if ( $stopScript ) {
            die;
        }
    }
}
