<?php

class Text {
    public static function charCountLimit($string, $count) {
        if ( isset($string) && $count > 0 ) {
            if ( $count < strlen($string) ) {
                return mb_substr($string, 0, $count, 'UTF-8') . '...';
            }

            return mb_substr($string, 0, $count, 'UTF-8');
        }
    }
}