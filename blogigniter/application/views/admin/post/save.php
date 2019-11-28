<?php echo form_open('', 'class="my_form" enctype="multipart/form-data"'); ?>
<div class="form-group">
    <?php
    echo form_label('Titulo', 'title');
    ?>
    <?php
    $text_input = array(
        'name' => 'title',
        'minlength' => 10,
        'maxlength' => 65,
        'required' => 'required',
        'id' => 'title',
        'value' => $title,
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>
    <?php echo form_error('title', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Url limpia', 'url_clean');
    ?>
    <?php
    $text_input = array(
        'name' => 'url_clean',
        'id' => 'url_clean',
        'value' => $url_clean,
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>
    <?php echo form_error('url_clean', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Contenido', 'content');
    ?>
    <?php
    $text_area = array(
        'name' => 'content',
        'id' => 'content',
        'value' => $content,
        'class' => 'form-control input-lg',
    );

    echo form_textarea($text_area);
    ?>
    <?php echo form_error('content', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Descripción', 'description');
    ?>
    <?php
    $text_area = array(
        'name' => 'description',
        'id' => 'description',
        'value' => $description,
        'class' => 'form-control input-lg',
    );

    echo form_textarea($text_area);
    ?>
    <?php echo form_error('description', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Imagen', 'image');
    ?>
    <?php
    $text_input = array(
        'name' => 'upload',
        'id' => 'upload',
        'value' => '',
        'type' => 'file',
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>

    <?php echo $image != "" ? '<img class="img_post img-thumbnail img-presentation-small" src="' . base_url() . 'uploads/post/' . $image . '">' : ""; ?>

</div>

<div class="form-group">
    <?php
    echo form_label('Publicado', 'posted');
    echo form_dropdown('posted', $data_posted, $posted, 'class="form-control input-lg"')
    ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Categorias', 'category_id');
    echo form_dropdown('category_id', $categories, $category_id, 'class="form-control input-lg"')
    ?>
</div>

<?php echo form_submit('mysubmit', 'Guardar', 'class="btn btn-primary"') ?>

<?php echo form_close() ?>

<script>
    $(function () {
        var editor = CKEDITOR.replace('content', {
            height: 400,
            filebrowserUploadUrl: "<?php echo base_url() ?>admin/upload",
            filebrowserBrowseUrl: "<?php echo base_url() ?>admin/images_server"
        });
    });
</script>

