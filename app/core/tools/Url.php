<?php

class Url {
    public static function to($route, $params = []) {
        $url = $route . '?';

        foreach ( $params as $key => $value ) {
            $url .= $key . '=' . $value . '&';
        }

        return trim($url, '&');
    }
}
