<?php

class Text {
    public static function charCountLimit($string, $count) {
        if ( $count > 0 && $count < strlen($string) ) {
            return mb_substr($string, 0, $count, 'UTF-8') . '...';
        }

        return $string;
    }
}