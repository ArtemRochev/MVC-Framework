<?php
foreach ( $data as $comment ) {
    echo sprintf(file_get_contents(VIEWS_PATH . 'admin/commentBlock.php'),
        $comment->user->name,
        $comment->text,
        $comment->time
    );
}

?>
