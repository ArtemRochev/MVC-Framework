<?php

class Html {
    public static function a($href, $text = null) {
        $href = 'http://' . $href;
        if ( !$text ) {
            $text = $href;
        }

        return "<a href=$href>$text</a>";
    }

    public static function tag($name, $text) {
        return "<$name>$text</$name>";
    }
}