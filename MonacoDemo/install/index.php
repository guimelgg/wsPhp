<?php
error_reporting(0);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <title>Monaco POS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
  	</head>
  	<body>
	<?php
		require_once('includes/core_class.php');
		require_once('includes/database_class.php');
		$db_config_path = "../app/config/database.php";
		$installPos = "../MON";
		$indexFile = "../index.php";
	?>
	<center><img src="assets/img/logo.png" alt="logo" class="logo"></center>
     	<div class="modal fade" id="install-modal" tabindex="-1" role="dialog">
       		<div class="modal-dialog">
            	<div class="installmodal-container">
			<?php
			if (is_file($installPos)) {
			$step  = isset($_GET['step']) ? $_GET['step'] : '0';
				switch($step){
				default:

				$error = FALSE;
				if(phpversion() < "5.3"){$error = TRUE; $check1 = "<span class='label label-danger'>Your PHP version is ".phpversion()."</span>";}else{$check1 = "<span class='label label-success'>v.".phpversion()."</span>";}
				if(!extension_loaded('mcrypt')){$error = TRUE; $check2 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check2 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
			   if(!extension_loaded('mbstring')){$error = TRUE; $check4 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check4 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
				if(!extension_loaded('mysqli')){$error = TRUE; $check12 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check12 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
				if(!extension_loaded('gd')){$check5 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check5 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
				if(!extension_loaded('pdo')){$error = TRUE; $check6 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check6 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
				if(!extension_loaded('dom')){$check7 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check7 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
				if(!extension_loaded('curl')){$error = TRUE; $check8 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check8 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
			   if(!is_writeable($db_config_path)){$error = TRUE; $check9 = "<span class='label label-danger'>Please make the application/config/database.php file writable.</span>";}else{$check9 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
				if(!is_writeable("../files")){$check10 = "<span class='label label-danger'>files folder is not writeable!</span>";}else{$check10 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
				if(ini_get('allow_url_fopen') != "1"){$check11 = "<span class='label label-warning'>Allow_url_fopen is not enabled!</span>";}else{$check11 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
				if(!extension_loaded('zip')){$error = TRUE; $check13 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check13 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}

			?>
				<ul class="nav nav-tabs">
		            <li class="active"><a>Requirements<p>Necessary Files</p></a></li>
						<li class=""><a>Database<p>Configuration</p></a></li>
						<li class=""><a>Web Site<p>Configuration</p></a></li>
		            <li class=""><a>End<p>Success !</p></a></li>
		         </ul>
				<div class="tab-content">
	            <div class="tab-pane fade in active" id="Checklist">
					<h3>Necessary Files</h3>
			        <table class="table table-striped">
					      <thead><tr><th>Requirements</th><th>Result</th></tr></thead>
					      <tbody>
								<tr><td>PHP 5.3+ </td><td><?php echo $check1; ?></td></tr>
								<tr><td>GD PHP extension</td><td><?php echo $check5; ?></td></tr>
								<tr><td>Mysqli PHP extension</td><td><?php echo $check12; ?></td></tr>
								<tr><td>Mcrypt PHP extension</td><td><?php echo $check2; ?></td></tr>
								<tr><td>MBString PHP extension</td><td><?php echo $check4; ?></td></tr>
								<tr><td>DOM PHP extension</td><td><?php echo $check7; ?></td></tr>
								<tr><td>Writing file folder extension</td><td><?php echo $check10; ?></td></tr>
								<tr><td>PDO PHP extension</td><td><?php echo $check6; ?></td></tr>
								<tr><td>CURL PHP extension</td><td><?php echo $check8; ?></td></tr>
								<tr><td>Allow_url_fopen is enabled</td><td><?php echo $check11; ?></td></tr>
								<tr><td>Writing the file (database.php)</td><td><?php echo $check9; ?></td></tr>
								<tr><td>ZIP extension</td><td><?php echo $check13; ?></td></tr>

					      </tbody>
					</table>
					<form method="get"><input type="hidden" name="step" value="1" />
				 	 	<button type="submit" class="btn btn-next <?=$error ? 'hide' : '';?>" href="">Next ></button>
					</form>
				</div>
				<?php
				break;
				case "1": ?>
				<ul class="nav nav-tabs">
					<li class=""><a>Requirements<p>Necessary Files</p></a></li>
					<li class="active"><a>Database<p>Configuration</p></a></li>
					<li class=""><a>Web Site<p>Configuration</p></a></li>
					<li class=""><a>End<p>Success !</p></a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane fade in active" id="Database">
						<form id="install_form" method="post" action="?step=1">
							<fieldset>
							<legend style="padding-top:20px">Database Configuration</legend>
							<div class="alert alert-dismissible alert-success">
	  							<i class="fa fa-database"></i> The installer will create the <strong>Database and the tables</strong>
							</div>

								<?php
								$hide = '';
								if($_POST) {
										$core = new Core();
										$database = new Database();
									if($core->validate_post($_POST) == true)
									{
										if($database->create_database($_POST) == false) {
											echo "<p style='color:#ED5565'>The Database could not be created, check its configuration</p>";
											$error = 1;
										} else if ($database->create_tables($_POST) == false) {
											echo "<p style='color:#ED5565'>The tables could not be created, check your configuration</p>";
											$error = 1;
										} else if ($core->write_database($_POST) == false) {
											echo "<p style='color:#ED5565'>The configuration could not be written to chmod app/config/database.php</p>";
											$error = 1;
										}
										if(!isset($error)) {
											echo '<div class="alert alert-dismissible alert-success">
				  								<i class="fa fa-check" style="margin:0 7px" aria-hidden="true"></i>The settings were saved correctly
												</div>';
											echo '<a href="index.php?step=2" class="label label-success" style="float:right;font-size:20px;"> Continue installation > </a>';
											$hide = 'hide';
										}
									}
								}?>
								<div class="form-group <?=$hide;?>">
									<label for="hostname">Hostname</label>
									<input type="text" required id="hostname" class="form-control" name="hostname" />
								</div>
								<div class="form-group <?=$hide;?>">
									<label for="database">Database</label>
									<input type="text" required id="database" class="form-control" name="database" />
								</div>
								<div class="form-group <?=$hide;?>">
									<label for="username">User</label>
									<input type="text" required id="username" class="form-control" name="username" />
								</div>
								<div class="form-group <?=$hide;?>">
									<label for="password">Password</label>
									<input type="password" id="password" class="form-control" name="password" />
								</div>
									<input type="submit" class="btn btn-next <?=$hide;?>" value="Install" id="submit" />
							 </fieldset>
							 </form>

					</div>

				<?php
				break;
				case "2": ?>
				<ul class="nav nav-tabs">
					<li class=""><a>Requirements<p>Necessary Files</p></a></li>
					<li class="in"><a>Database<p>Configuration</p></a></li>
					<li class="active"><a>Web Site<p>Configuration</p></a></li>
					<li class=""><a>End<p>Success !</p></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade in active" id="Config">
						<fieldset>
							<legend style="padding-top:20px">Web Site</legend>
							<form id="install_form" method="post" action="?step=2">
							<?php if($_POST){
								$core = new Core();
								$domain = $_POST['domain'];
								$timezone  = $_POST['timezone'];

						define("BASEPATH", "install/");
						include("../app/config/database.php");
						$con=mysqli_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

						$settings = mysqli_query($con,"UPDATE mon_settings SET timezone='$timezone' WHERE timezone='America';");

						if ($core->write_config($domain) == false) {
							echo "<div class='alert alert-error'><i class='icon-remove'></i> Error writing configuration details in config/config.php</div>";
						}elseif ($core->write_index($timezone) == false) {
							echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write timezone details to ".$indexFile."</div>";
									}
							{
							echo '<div class="alert alert-dismissible alert-success">
				  					<i class="fa fa-check" style="margin:0 7px" aria-hidden="true"></i>
				  					The settings were saved correctly
								</div>';
							echo '<a href="index.php?step=3" class="label label-success" style="float:right;font-size:20px;"> Continue installation > </a>';
							$hide = 'hide';
							}
						}
								?>
						 
						<div class="form-group <?=$hide;?>">
							<label for="domain">Domain *</label>
							<input type="text" name="domain" class="form-control" value="<?php echo "http://".$_SERVER["HTTP_HOST"].substr($_SERVER["REQUEST_URI"], 0, -25);?>" required/>
						</div>
						<div class="form-group <?=$hide;?>">
					          <label class="control-label" for="domain">Time Zone</a></label>
					          <div class="controls">
					            <?php
									require_once('includes/timezones_class.php');
									$tz = new Timezones();
									$timezones = $tz->get_timezones();
									echo '<select name="timezone" required="required" data-error="TimeZone is required" class="form-control">';
						            foreach ($timezones as $key => $zone){
						            echo '<option value="'.$key.'">'.$zone.'</option>';
						            }
						            echo '</select>'; ?>
					          </div>
				        </div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-1 col-sm-offset-1">
									<a href="index.php?step=1" class="btn btn-default pull-right">Previous</a>
								</div>
								<div class="col-sm-2 col-sm-offset-8">
									<input type="submit" class="btn btn-next <?=$hide;?>" value="Next" id="submit" />
								</div>
							</div>
						</div>
						</fieldset>
							</form>
					</div>
				<?php
				break;
				case "3": ?>
				<ul class="nav nav-tabs">
					<li class=""><a>Requirements<p>Necessary Files</p></a></li>
					<li class=""><a>Database<p>Configuration</p></a></li>
					<li class=""><a>Web Site<p>Configuration</p></a></li>
					<li class="active"><a>End<p>Success !</p></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade in active" id="Done">
						<h1>Installation completed</h1>	
	            		<div class="alert alert-dismissible alert-success">
	  						Start session:<br /><br />
	            			User: <span style="font-weight:bold; letter-spacing:1px;">admin@admin.com</span><br />Password: <span style="font-weight:bold; letter-spacing:1px;">12345678</span><br /><br />
						</div>

	            		<div class="bg-warning"><i class='icon-warning-sign'></i> Remember to change the session data
	            		</div>
						<?php @unlink('../MON'); ?>
						<a href="<?php echo "http://".$_SERVER["HTTP_HOST"].substr($_SERVER["REQUEST_URI"], 0, -25); ?>" class="btn btn-next">Log in</a>
					</div>
            	</div>
					<?php } ?>
					<?php }else{ ?>
					<div class="tab-content">
						<h1><i class="fa fa-check" aria-hidden="true" style="margin-right:10px"></i>Installation completed</h1>
						<p>	You can delete this directory manually</p>
					<?php } ?>
         			</div>
       </div>

      <!-- jQuery -->
      <script type="text/javascript" src="assets/js/jquery-2.2.2.min.js"></script>
      <!-- efecto waves material -->
      <script type="text/javascript" src="assets/js/waves.min.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

      <script type="text/javascript">
      $(document).ready(function() {
         $('#install-modal').modal('show').on('hide.bs.modal', function (e) {
            e.preventDefault();
         });
      });
		var currency = document.getElementById("Currency");

		function validatecurrency(){
		  if(currency.value.length < 3) {
		    currency.setCustomValidity("The Currency code must be at least 3 characters length");
		  } else {
		    currency.setCustomValidity('');
		  }
		}
		if(currency) currency.onchange = validatecurrency;
      </script>
   </body>
</html>
