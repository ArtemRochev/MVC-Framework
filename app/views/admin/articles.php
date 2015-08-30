<?php

foreach ( $data as $article ) {
    echo sprintf(file_get_contents(VIEWS_PATH . 'admin/articleBlock.php'),
        $article->title,
        $article->author->name,
        $article->created,
        $article->content,
        $article->id
    );
}

?>


<form id="addComment" role="form" method="post" action="/admin?a=save-article">
	<h3>Добавить статью</h3>

	<div class="form-group">
		<label>Заголовок</label>
		<input type="text" name="title" required>

		<label>Ид автора</label>
		<input type="text" value="2" name="author_id" required>
	</div>
	<div class="form-group">
		<label>Текст</label>
		<textarea rows="3" name="content" required></textarea>
	</div>
	<div class="form-group">
 		<button class="btn btn-info">Предварительный просмотр</button>
 		<button type="submit" class="btn btn-success">Отправить</button>
	</div>
</form>

