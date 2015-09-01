<?php

require_once(CORE_PATH . 'tools/Text.php');

foreach ( $data as $article ) {
    echo sprintf(file_get_contents(VIEWS_PATH . 'articleBlock.php'),
        $article->id,
        $article->title,
        $article->img_preview_url,
        Text::charCountLimit($article->content, 2000),
        $article->created
    );
}

?>
