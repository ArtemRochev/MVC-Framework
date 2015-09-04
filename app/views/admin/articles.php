<a href="/admin?a=modify-article" class="button">Создать статью</a>

<?php
	foreach ( $data as $article ) {
		echo sprintf(file_get_contents(VIEWS_PATH . 'admin/articleBlock.php'),
			$article->title,
			$article->author->name,
			$article->created,
			$article->img_preview_url,
			$article->content,
			$article->id
		);
	}
?>
