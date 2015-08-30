<div id="commentsList">
	<?php
		foreach ( $data as $comment ) {
			echo sprintf(file_get_contents(PROJ_PATH . 'app/views/commentBlock.php'),
				$comment->user->name,
				$comment->text,
				$comment->time
			);
		}

	?>
</div>

<form id="addComment" role="form" method="post" action="/comments/save">
	<h3>Оставить комментарий</h3>

	<div class="form-group">
		<label for="name">Имя</label>
		<input type="text" id="name" name="name" placeholder="Ваше имя" required>

		<label for="email">Email</label>
		<input type="email" id="email" name="email" placeholder="Ваш email" required>
	</div>
	<div class="form-group">
		<label for="message">Ваше сообщение</label>
		<textarea rows="3" id="message" name="text" required></textarea>
	</div>
	<div class="form-group">
 		<button class="btn btn-info">Предварительный просмотр</button>
 		<button type="submit" class="btn btn-success">Отправить</button>
	</div>
</form>
