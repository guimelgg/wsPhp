<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>PymeTI</title>
  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="<?php echo base_url(); ?>assets/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php echo base_url(); ?>assets/css/grayscale.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">
        <img src="<?php echo base_url(); ?>assets/img/PymeTI.png" alt="Thumbnail image" class="img-fluid">
      </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
        data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
        aria-label="Desplegar menú de navegaación">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#ventajas">Ventajas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#projects">Ver planes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#signup">Contactanos</a>
          </li>
          <?php if($this->session->userdata('user')){ ?>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#">Tu Cuenta</a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="login">Iniciar sesión</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="register">Abrir cuenta</a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead">
    <div class="container d-flex h-100 align-items-center">
      <div class="mx-auto text-center">
        <h1 class="mx-auto my-0 ">PymeTI </h1>
        <h2 class="text-white-50 mx-auto mt-2 mb-5">Sistema Punto de Venta</h2>
        <h4 class="text-white-50 mx-auto mt-2 mb-5">Descarga tu Demo ahora.</h4>
        <a href="#" class="btn btn-primary js-scroll-trigger">Iniciar registro</a>
      </div>
    </div>
  </header>

  <!-- Ventajas Section,About -->
  <section id="ventajas" class="about-section text-left">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2 class="text-white mb-4">Tu Información siempre segura y accesible</h2>
          <p class="text-white-50">
            La información se almacena en la nube por seguridad y accesibilidad<br>
            Otra copia en tu dispositivo lo que te permite consultar la información aún sin conexión a Internet.<br>
            El software funciona en cualquier computadora con Windows y conexión a Internet.</p>
        </div>
      </div>
      <img src="assets/img/ipad.png" class="img-fluid" alt="">
    </div>
  </section>

  <!-- Planes,Projects Section -->
  <section id="projects" class="projects-section bg-light py-4">
    <div class="container">
      <h1 class="display-4 font-weight-bold text-center pb-4">Elige el plan a tu medida</h1>
      <div class="row text-md-center">
        <article class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
          <div class="card">
            <h2 class="card-header">Básico</h2>
            <div class="card-body">
              <h5 class="card-title">$280 <small class="text-muted font-weight-lighter">Mes en plan anual</small></h5>
              <h6 class="card-subtitle"></h6>
              <p class="card-text text-left list-unstyled">
                2 GB de Almacenamiento<br>
                1 Sucursal<br>
                Dispositivos ilimitados<br>
                Artículos ilimitados
              </p>
            </div>
          </div>
        </article>
        <article class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
          <div class="card">
            <h2 class="card-header">Plus</h2>
            <div class="card-body">
              <h5 class="card-title">$600 <small class="text-muted font-weight-lighter">Mes en plan anual</small></h5>
              <h6 class="card-subtitle"></h6>
              <p class="card-text text-left list-unstyled">
                6 GB de Almacenamiento<br>
                3 Sucursal<br>
                Dispositivos ilimitados<br>
                Artículos ilimitados
              </p>
            </div>
          </div>
        </article>
        <article class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
          <div class="card">
            <h4 class="card-header">Sucursal Adicional</h4>
            <div class="card-body">
              <h5 class="card-title">$250 <small class="text-muted font-weight-lighter">Mes en plan anual</small></h5>
              <h6 class="card-subtitle"></h6>
              <p class="card-text text-left list-unstyled">
                2 GB de Almacenamiento adicional<br>
                Es necesario contar con el plan Básico o Plus
              </p>
            </div>
          </div>
        </article>
        <article class="col-12 col-md-6 col-lg-3   mb-3 mb-lg-0">
          <div class="card">
            <h4 class="card-header">Almacenamiento Adicional</h4>
            <div class="card-body">
              <h5 class="card-title">$90<small class="text-muted font-weight-lighter">Mes en plan anual</small></h5>
              <h6 class="card-subtitle"></h6>
              <p class="card-text text-left list-unstyled">
                1 GB de Almacenamiento adicional<br>
                Es necesario contar con el plan Básico o Plus
              </p>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>
  <!-- Contacto Section -->
  <section id="signup" class="signup-section">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-lg-8 mx-auto text-center">
          <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
          <h2 class="text-white mb-5">Favor de dejar tus datos para contactarnos a la brevedad</h2>
          <form name="sentMessage" id="contactForm" novalidate="novalidate" class="user">
            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-2">
                <input class="form-control form-control-user" id="name" type="text" placeholder="Nombre"
                  required="required" data-validation-required-message="El Nombre es requerido">
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <div class="control-group">
              <div class="form-group controls mb-0 pb-2">
                <input class="form-control form-control-user" id="email" type="email" placeholder="Email"
                  required="required" data-validation-required-message="El Email no es valido">
                  <p class="help-block text-danger"></p>
                <!---->
              </div>
            </div>
            <div class="control-group">
              <div class="form-group floating-label-form-group controls mb-0 pb-2">
                <textarea class="form-control form-control-user" id="message" rows="5"
                  placeholder="Favor de ingresar el mensaje." required="required" data-validation-required-message="El mensaje no es valido"></textarea>
                <p class="help-block text-danger"></p>
              </div>
            </div>
            <br>
            <div id="success"></div>
            <div class="form-group">
              <label class="text-white"><input type="checkbox" value="Yes" id="AvisoPrivacidad">He leído el Aviso de
                Privacidad</label>
              <button type="submit" class="btn btn-primary btn-xl" id="sendMessageButton">Enviar</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </section>

  <!-- Otros contactos -->
  <section class="contact-section bg-black">
    <div class="container">

      <div class="row">

        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card py-4 h-100">
            <div class="card-body text-center">
              <i class="fas fa-map-marked-alt text-primary mb-2"></i>
              <h4 class="text-uppercase m-0">Ventas</h4>
              <hr class="my-4">
              <div class="small text-black-50">
                <a href="#">ventas@pymeti.com</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card py-4 h-100">
            <div class="card-body text-center">
              <i class="fas fa-envelope text-primary mb-2"></i>
              <h4 class="text-uppercase m-0">Soporte Técnico</h4>
              <hr class="my-4">
              <div class="small text-black-50">
                <a href="#">soporte@pymeti.com</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card py-4 h-100">
            <div class="card-body text-center">
              <i class="fas fa-comments text-primary mb-2"></i>
              <h4 class="text-uppercase m-0">Chat</h4>
              <hr class="my-4">
              <div class="small text-black-50">Iniciar</div>
            </div>
          </div>
        </div>
      </div>

      <div class="social d-flex justify-content-center">
        <a href="#" class="mx-2">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="#" class="mx-2">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="mx-2">
          <i class="fab fa-github"></i>
        </a>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-black small text-center text-white-50">
    <div class="container">
      Copyright &copy; Pymeti 2019
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js"></script>

  <!-- Contact Form JavaScript -->
  <script src="<?php echo base_url(); ?>assets/js/jqBootstrapValidation.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="<?php echo base_url(); ?>assets/js/grayscale.js"></script>

</body>

</html>