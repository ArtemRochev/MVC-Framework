<form id="addArticle" class="w-limmiter" role="form" method="post" action="/admin/save-article">
    <h3>Добавить статью</h3>

    <div class="form-group">
        <label>Заголовок</label>
        <input type="text" name="title" required>

        <label>Картинка превью (URL)</label>
        <input type="text" name="img_preview_url">
        <img class="img-preview hidden">
    </div>
    <div class="form-group">
        <label>Текст</label>
        <textarea rows="3" name="content" required></textarea>
    </div>
    <div class="form-group">
        <a class="btn btn-blue" href="#" target="_blank">Предварительный просмотр</a>
        <button type="submit" class="btn btn-green">Отправить</button>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var form = $('#addArticle');
        var imgInput =   form.find('input[name=img_preview_url]');
        var imgPreview = form.find('.img-preview');

        imgInput.change(function() {
            imgPreview.attr('src', $(this).val());

            imgPreview.load(function() {
                imgInput.removeClass('fail');
                //imgInput.addClass('success');
                imgPreview.removeClass('hidden');
            });

            imgPreview.error(function() {
                //imgInput.removeClass('success');
                imgInput.addClass('fail');
                imgPreview.addClass('hidden');
            });
        });
    });
</script>











