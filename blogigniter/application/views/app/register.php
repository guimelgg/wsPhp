<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>PymeTI Registro</title>

  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/grayscale.css" rel="stylesheet">
  <script type="text/javascript">
    var url = '<?php echo base_url(); ?>';
  </script>
</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">      
      <a href="<?php echo base_url() ?>inicio"><?php echo APP_NAME ?>
      <!-- <img class="card-img-top h-100 w-50 p-3" src="img/PymeTI.png" alt="Proyecto 1">-->
      </a>
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-10">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Crear una cuenta!</h1>
              </div>
              <form class="user" id="logForm">
              <div class="form-group">                  
                  <input type="text" class="form-control form-control-user" placeholder="Usuario" name="username" required="required" pattern="[A-Za-z]{1,32}">
                  <p class="help-block text-danger"></p>
                </div>
              
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" id="email" required="required" placeholder="Email" name="email">
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0" >
                    <input type="password" class="form-control form-control-user" id="password" required="required" placeholder="Contraseña" name="passwd" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,72}$" title="(8 o mas caracteres, 1 número, 1 mayúscula,1 minúscula)">
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="repeatpassword" required="required" placeholder="Repetir Contraseña" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,72}$">
                    <p class="help-block text-danger"></p>
                  </div>
                </div>
                <div id="success"></div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-user btn-block"><span id="logText">Registrar Cuenta</span></button>                  
                </div>
                <hr>
              </form>
              <hr>
              <div id="responseDiv" class="alert text-center" style="margin-top:20px; display:none;">
                <button type="button" class="close" id="clearMsg"><span aria-hidden="true">&times;</span></button>                
              </div>	              
              <div class="text-center">
                <a class="small" href="forgot-password.html">Olvidaste la contraseña?</a>
              </div>
              <div class="text-center">
                <a class="small" href="login">Ya tienes cuenta? Inicia Sesión!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/jquery.toaster.js"></script>
  
  
  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>assets/js/register.js"></script>

</body>

</html>