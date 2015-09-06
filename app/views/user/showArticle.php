<div class="page">
    <div class="content">
        <h1 class="title">
            <?= $data['article']->title ?>
        </h1>
        <p class="text">
            <?= $data['article']->content ?>
        </p>
        <p class="time">
            <?= $data['article']->created ?>
        </p>
    </div>
</div>

<h2>
    Коментарии
</h2>
<p class="commentCount">Количество: <?= $data['commentsCount'] ?> </p>

<div id="commentsList">
    <?php foreach ( $data['comments'] as $comment ) { ?>
        <div class="comment-block">
            <h3 class="author">
                <?= $comment->author->name; ?>
            </h3>
            <p class="text">
                <?= $comment->text; ?>
            </p>
        </div>
    <?php }?>
</div>


<form id="addComment" role="form" method="post" action="<?= Url::to('article/save-comment') ?>">
    <h3>Написать коментарий</h3>

    <label>Ид автора</label>
    <input type="text" value="1" name="author_id" required>

    <label>Текст</label>
    <textarea rows="5" name="text" required></textarea>

    <input type="hidden" name="article_id" value="<?= $data['article']->id ?>">
    <button type="submit" class="btn">Отправить</button>
</form>
