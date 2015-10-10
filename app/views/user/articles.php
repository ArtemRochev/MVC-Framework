<?php

require_once(TOOLS_PATH . 'Text.php');

foreach ( $data as $article ) {
    echo sprintf(file_get_contents(VIEWS_PATH . 'user/articleBlock.php'),
        $article->url,
        $article->title,
        $article->img_preview_url,
        Text::charCountLimit($article->content, 2000),
        $article->created
    );
}

?>
