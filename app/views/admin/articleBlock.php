<div class="article-block">
	<p class="title">%s</p>
	<p class="author">Автор: %s</p>
	<p class="time">%s</p>
	<img src="%s" alt="">
	<p class="content">%s</p>

	<form method="post" action="/admin?a=delete-article">
		<input type="hidden" name="id" value="%s">
		<ul class="button-panel">
			<button type="submit" class="red-btn button">Удалить</button>
			<button type="submit" class="blue-btn button">Изменить</button>
		</ul>
	</form>
</div>