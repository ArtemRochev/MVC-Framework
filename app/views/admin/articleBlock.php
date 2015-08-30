<div class="article-block">
	<p class="title">%s</p>
	<p class="author">Автор: %s</p>
	<p class="time">%s</p>
	<p class="content">%s</p>

	<form method="post" action="/admin?a=delete-article">
		<input type="hidden" name="id" value="%s">
		<button type="submit" class="delete-btn"></button>
	</form>
</div>