<div class="article-block">
	<p class="title">
		<?= $data['article']->title ?>
	</p>
	<p class="info-small">
		Автор: <?= $data['article']->author->name ?>
	</p>
	<p class="info-small">
		Коментариев: <?= $data['article']->getCommentCount() ?>
	</p>
	<p class="info-small">
		Создано: <?= $data['article']->created ?>
	</p>
	<img src="<?= $data['article']->img_preview_url ?>" alt="">
	<p class="content">
		<?= $data['article']->content ?>
	</p>
	<ul class="button-panel">
		<li>
			<a href="<?= Url::to('admin/delete-article', ['id' => $data['article']->id]) ?>" class="btn btn-red">Удалить</a>
		</li>
		<li>
			<a href="<?= Url::to('admin/modify-article', ['id' => $data['article']->id]) ?>" class="btn btn-blue">Изменить</a>
		</li>
	</ul>
	</form>
</div>