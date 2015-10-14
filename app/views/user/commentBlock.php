<div class="comment-block">
    <h3 class="author">
        <?= $data->author->name; ?>
    </h3>
    <p class="text">
        <?= $data->text; ?>
    </p>

    <form class="button-panel" method="post" action="/article/delete-comment">
        <input type="hidden" name="id" value="<?= $data->id ?>">
        <?php
            if ( App::isAdmin() ) {
                echo '<button class="btn">delete</button>';
            }
        ?>
    </form>
</div>