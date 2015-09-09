<?php

class Text {
    public static function charCountLimit($string, $count) {
        if ( $count > 0 && $count < strlen($string) ) {
            return mb_substr($string, 0, $count, 'UTF-8') . '...';
        }

        return $string;
    }

    public static function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $string = '';

        for ( $i = 0; $i < $length; $i++ ) {
            $string .= $characters[rand(0, $charactersLength - 1)];
        }

        return $string;
    }
}