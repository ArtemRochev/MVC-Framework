<?php
	foreach ( $data as $comment ) {
		echo sprintf(file_get_contents(PROJ_PATH . 'app/views/commentBlock.php'),
			$comment->user->name,
			$comment->text,
			$comment->time
		);
	}

?>

