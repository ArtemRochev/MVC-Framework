<a href="/admin/article/modify" class="btn">Создать статью</a>

<?php
	foreach ( $data as $article ) {
		$this->includeTemplate('admin/articleBlock.php', ['article' => $article]);
	}
?>
