<?php

class Url {
    public static function to($route, $params = []) {
        $url = $route . '?';

        if ( !empty($_GET['debug']) ) {
            $params['debug'] = 1;
        }

        foreach ( $params as $key => $value ) {
            $url .= $key . '=' . $value . '&';
        }

        return trim($url, '&?');
    }
}
