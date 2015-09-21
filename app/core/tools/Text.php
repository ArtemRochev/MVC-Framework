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

    // convert: some-text -> SomeText
    public static function hyphenSeparatedToCamelCase($string) {
        $action = ucfirst($string);
        $valueLen = strlen($action);

        for ( $i = 0; $i < $valueLen; $i++ ) {
            if ( $action[$i] == '-' && $i < $valueLen - 1 ) {
                $action[$i+1] = ucfirst($action[$i+1]);
            }
        }

        return str_replace('-', '', $action);
    }
}