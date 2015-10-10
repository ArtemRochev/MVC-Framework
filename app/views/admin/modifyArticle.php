<form id="addArticle" class="w-limmiter" role="form" method="post" action="/admin/article/save">
    <h3>
        Редактировать статью
    </h3>

    <div class="form-group">
        <label>Заголовок</label>
        <input type="text" name="title" value="<?= $data['article']->title ?>" required>

        <label>Картинка превью (URL)</label>
        <input type="text" name="img_preview_url" value="<?= $data['article']->img_preview_url ?>">
        <img class="img-preview hidden">
    </div>
    <div class="form-group">
        <label>Текст</label>
        <textarea rows="3" name="content" required>
            <?= $data['article']->content ?>
        </textarea>
    </div>
    <div class="form-group">
        <input type="hidden" name="id" value="<?= $data['article']->id ?>" required>
        <a class="btn btn-blue" href="#" target="_blank">Предварительный просмотр</a>
        <button type="submit" class="btn btn-green">Отправить</button>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
    function setImgPreview(form, imgInput, imgPreview) {
        imgPreview.attr('src', imgInput.val());

        imgPreview.load(function() {
            imgInput.removeClass('fail');
            imgPreview.removeClass('hidden');
        });

        imgPreview.error(function() {
            imgInput.addClass('fail');
            imgPreview.addClass('hidden');
        });
    }

    $(document).ready(function() {
        var form = $('#addArticle');
        var imgInput =   form.find('input[name=img_preview_url]');
        var imgPreview = form.find('.img-preview');

        setImgPreview(form, imgInput, imgPreview);

        imgInput.change(function() {
            setImgPreview(form, imgInput, imgPreview);
        });
    });
</script>











