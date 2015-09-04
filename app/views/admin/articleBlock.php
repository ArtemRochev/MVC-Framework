<div class="article-block">
	<p class="title">%s</p>
	<p class="author">Автор: %s</p>
	<p class="time">%s</p>
	<img src="%s" alt="">
	<p class="content">%s</p>

	<form method="post" action="/admin/delete-article">
		<input type="hidden" name="id" value="%s">
		<ul class="button-panel">
			<li><button type="submit" class="btn btn-red">Удалить</button></li>
			<li><button type="submit" class="btn btn-blue">Изменить</button></li>
		</ul>
	</form>
</div>