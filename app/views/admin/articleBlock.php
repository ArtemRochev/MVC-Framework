<div class="article-block">
	<p class="title">%s</p>
	<p class="author">Автор: %s</p>
	<p class="time">%s</p>
	<img src="%s" alt="">
	<p class="content">%s</p>

	<form method="post" action="/admin?a=delete-article">
		<input type="hidden" name="id" value="%s">
		<button type="submit" class="delete-btn article-control-btn">Удалить</button>
		<button type="submit" class="modify-btn article-control-btn">Изменить</button>
	</form>
</div>