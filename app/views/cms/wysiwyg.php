<?php
include __DIR__ . '/cmsSidebar.php';
?>

<script
        type="text/javascript"
        src='https://cdn.tiny.cloud/1/z3jn3c7rnt7c3w236hmoxjo7dsyjg5jz9y1vq2cn996q2gmf/tinymce/6/tinymce.min.js'
        referrerpolicy="origin">
</script>
<script type="text/javascript">
    tinymce.init({
        selector: '#myTextarea',
        height: 600,
        plugins: [
            'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
            'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
            'media', 'table', 'emoticons', 'template', 'help'
        ],
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
            'forecolor backcolor emoticons | help',
        menu: {
            favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
        },
        menubar: 'favs file edit view insert format tools table help',
    });
    
</script>
<a href="/cms/wysiwygmanagement" class="btn btn-primary"><-</a>

<form action="/cms/wysiwyg" method="post">
    <textarea name="myTextarea" id="myTextarea">
        <?php echo $page[0]->htmlData; ?>
    </textarea>
    <input type="hidden" id="page" name="page" value="">
    <input type="hidden" id="id" name="id" value="<?php echo $page[0]->id; ?>">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
