<?php
foreach ( $data as $article ) {
    echo sprintf(file_get_contents(VIEWS_PATH . 'articleBlock.php'),
        $article->title,
        $article->content,
        $article->created
    );
}

?>
