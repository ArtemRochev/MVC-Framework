<?php

function _debug($msg, $args = null){
    if ( !empty($_GET['debug']) ) {
        $msg = "<p style=\"font-size:13;color:rgb(22, 64, 72)\">$msg</p>";

        if ( $args ) {
            echo vsprintf(str_replace('?', '%s', $msg), $args);
        } else {
            echo $msg;
        }
    }
}
