<?php
//global $db;
//$ggg="Hola";
function connectDB($strDBName){
  global $db;
  //Conectar a la BD
  if ($strDBName) {
    $strPath = "database/".$strDBName;//patris.db
    $db = new PDO('sqlite:'.$strPath);
    //$db -> exec("SET CHARACTER SET utf8");
  }
}

 ?>
