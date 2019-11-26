<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title.' | '.$Settings->site_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
    <?php if ($this->db->dbdriver != 'sqlite3') { ?>
    <script type="text/javascript">if (parent.frames.length !== 0) { top.location = '<?=site_url('login')?>'; }</script>
    <?php } ?>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">
    <link href="<?= $assets ?>dist/css/styles.css" rel="stylesheet" type="text/css" />
    <link href="<?= $assets ?>dist/css/fonts.css" rel="stylesheet" type="text/css" />
    <?= $Settings->rtl ? '<link href="'.$assets.'dist/css/rtl.css" rel="stylesheet" />' : ''; ?>

    <style media="screen">
    body {
             background: url(<?=$assets?>images/monaco.png) no-repeat center center fixed;
            /*background:#1B2631;*/
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
         }
    </style>

</head>
<body class="login-page login-page-<?= $Settings->theme_style; ?> rtl rtl-inv">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?=base_url();?>"><?= $Settings->site_name == 'MonacoPOS' ? '<b>Monaco POS</b>' : '<img src="'.base_url('uploads/'.$Settings->logo).'" alt="'.$Settings->site_name.'" />'; ?></a>
        </div>
        <div class="login-box-body">
            <?php if ($error)  { ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?= $error; ?>
            </div>
            <?php } if ($message) { ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?= $message; ?>
            </div>
            <?php } ?>
            <p class="login-box-msg"><?= lang('login_to_your_account'); ?></p>
            <?= form_open("auth/login"); ?>
            <div class="form-group has-feedback">
                <input type="text" name="identity" value="<?= set_value('identity', (PLUG ? 'admin@admin.com' : '')); ?>" class="form-control" placeholder="<?= lang('email'); ?>" />
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" value="<?= PLUG ? '12345678' : ''; ?>" class="form-control" placeholder="<?= lang('password'); ?>" />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="checkbox pull-left" style="margin-top: 0;">
                <div class="custom-checkbox">
                    <?php echo form_checkbox('remember', '1', TRUE, 'id="remember"'); ?>
                    <label for="remember" style="padding-left:5px;"><?= lang('remember_me') ?></label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="glyphicon glyphicon-log-in"></i> &nbsp;<?= lang('sign_in'); ?></button><br>

<?= (PLUG) ?  
        '<div class="alert alert-success alert-dismissable">  
                     <strong>User:</strong> admin@admin.com<br>
                     <strong>Pass:</strong> 12345678
                 </div>' : ''; ?>

            <?= form_close(); ?>

            <div class="">
                <p>&nbsp;</p>
                <p><span class="text-danger"><?= lang('forgot_your_password'); ?></span><br>
                    <?= lang('dont_worry'); ?> <a href="#" class="text-danger" data-toggle="modal" data-target="#myModal"><?= lang('click_here'); ?></a> <?= lang('to_reset'); ?> </p>

                </div>

            </div>
        </div>

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
        class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open("auth/forgot_password"); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</i></button>
                    <h4 class="modal-title"><?= lang('forgot_password'); ?></h4>
                </div>
                <div class="modal-body">
                    <p><?= lang('forgot_password_heading'); ?></p>
                    <input type="email" name="forgot_email" placeholder="<?= lang('email'); ?>" autocomplete="off"
                    class="form-control placeholder-no-fix">
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default pull-left" type="button"><?= lang('close'); ?></button>
                    <button class="btn btn-primary" type="submit"><?= lang('submit'); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <script src="<?= $assets ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?= $assets ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= $assets ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
        $(function () {
            if ($('#identity').val())
                $('#password').focus();
            else
                $('#identity').focus();
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>
</body>
</html>
