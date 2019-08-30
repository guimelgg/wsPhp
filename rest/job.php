<?php
header("Content-Type:application/json");
if (!ob_start("ob_gzhandler")) {
    ob_start();
}
try {
    include('clsRutinas.php');      
    CallAPI("POST","wswcf.azurewebsites.net/rest/api.php",array("strOpcion" => "RespBDRemota"));
} catch (PDOException $e) {
    echo 'Exception : '.$e->getMessage();
}      