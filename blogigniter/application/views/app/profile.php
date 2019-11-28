<div class="row">

    <div class="col-lg-12">
        <br>
        <div class="box-center bg-profile">
            <img src="<?php echo image_user($this->session->userdata("id")) ?>" class="user-image img-profile" alt="User Image">
        </div>
        <br>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4><i class="fa fa-cog"></i> Cambio de contraseña</h4>
            </div>
            <div class="card-body">
                <?php echo form_open('', 'class="my_form"'); ?>
                <div class="form-group">
                    <?php
                    echo form_label('Contraseña actual', 'old_pass');
                    ?>
                    <?php
                    $text_input = array(
                        'name' => 'old_pass',
                        'minlength' => 8,
                        'maxlength' => 72,
                        'required' => 'required',
                        'id' => 'old_pass',
                        'value' => '',
                        'type' => 'password',
                        'class' => 'form-control input-lg',
                    );

                    echo form_input($text_input);
                    ?>
                    <?php echo form_error('old_pass', '<div class="text-danger">', '</div>') ?>
                </div>


                <div class="form-group">
                    <?php
                    echo form_label('Contraseña nueva', 'new_pass');
                    ?>
                    <?php
                    $text_input = array(
                        'name' => 'new_pass',
                        'minlength' => 8,
                        'maxlength' => 72,
                        'required' => 'required',
                        'id' => 'new_pass',
                        'value' => '',
                        'type' => 'password',
                        'class' => 'form-control input-lg',
                    );

                    echo form_input($text_input);
                    ?>
                    <?php echo form_error('new_pass', '<div class="text-danger">', '</div>') ?>

                </div>

                <div class="form-group">
                    <?php
                    echo form_label('Repita la nueva contraseña', 'new_pass_veri');
                    ?>
                    <?php
                    $text_input = array(
                        'name' => 'new_pass_veri',
                        'minlength' => 8,
                        'maxlength' => 72,
                        'required' => 'required',
                        'id' => 'new_pass_veri',
                        'value' => '',
                        'type' => 'password',
                        'class' => 'form-control input-lg',
                    );

                    echo form_input($text_input);
                    ?>
                    <?php echo form_error('new_pass_veri', '<div class="text-danger">', '</div>') ?>


                </div>
                <?php echo form_submit('mysubmit', 'Guardar', 'class="btn btn-primary"') ?>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4><i class="fa fa-user"></i> Datos de usuario</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <?php
                    echo form_label('Usuario', 'username');
                    ?>
                    <?php
                    $text_input = array(
                        'readonly' => 'readonly',
                        'value' => $this->session->userdata('name'),
                        'class' => 'form-control input-lg',
                    );
                    echo form_input($text_input);
                    ?>
                    <?php echo form_error('username', '<div class="text-error">', '</div>') ?>
                </div>
                <div class="form-group">
                    <?php
                    echo form_label('Email', 'email');
                    ?>
                    <?php
                    $text_input = array(
                        'readonly' => 'readonly',
                        'value' => $this->session->userdata('email'),
                        'class' => 'form-control input-lg',
                    );
                    echo form_input($text_input);
                    ?>
                    <?php echo form_error('email', '<div class="text-error">', '</div>') ?>
                </div>


                <form action="<?php echo base_url() ?>app/load_avatar" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>
                            Avatar
                        </label>
                        <input type="file" name="image" class="form-control input-lg">
                    </div>
                    <input type="submit" value="Enviar" class="btn btn-primary">
                </form>

            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function () {
        $(".img-profile").click(function () {
            $("[name=image]").trigger("click");
        });
    };
</script>