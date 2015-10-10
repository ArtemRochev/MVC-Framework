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

    public static function translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );

        return strtr($string, $converter);
    }

    public static function translitUrl($string) {
        return preg_replace('/[^a-zA-Z0-9-\s]/', '', self::translit(str_replace(' ', '-', $string)));
    }
}