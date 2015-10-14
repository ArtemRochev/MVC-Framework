<?php

function _debug($msg, $args = null, $stopScript = false){
    if ( !empty($_GET['debug']) && $_SERVER['REMOTE_ADDR'] == '93.73.24.222' ) {
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
