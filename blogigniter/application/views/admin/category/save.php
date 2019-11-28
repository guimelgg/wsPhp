<?php echo form_open('', 'class="my_form"'); ?>
<div class="form-group">
    <?php
    echo form_label('Nombre', 'name');
    ?>
    <?php
    $text_input = array(
        'name' => 'name',
        'id' => 'name',
        'value' => $name,
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>
    <?php echo form_error('name', '<div class="text-error">', '</div>') ?>
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
    <?php echo form_error('url_clean', '<div class="text-error">', '</div>') ?>
</div>

<?php echo form_submit('mysubmit', 'Guardar', 'class="btn btn-primary"') ?>

<?php echo form_close() ?>
