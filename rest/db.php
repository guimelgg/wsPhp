<?php
//global $db;
//$ggg="Hola";
function connectDB($strDBName){
  global $db;
  //Conectar a la BD
  if ($strDBName) {
    $strPath = "../../database/".$strDBName;
    //$strPath = "database/".$strDBName;
    $db = new PDO('sqlite:'.$strPath);
    //$db -> exec("SET CHARACTER SET utf8");
  }
}
function connectDB3($strDBName){
  global $db3;
  //Conectar a la BD
  if ($strDBName) {
    $strPath = "../../database/".$strDBName;
    //$strPath = "database/".$strDBName;
    $db3 = new SQLite3($strPath);    
    $db3->busyTimeout(5000);
    $db3->exec('PRAGMA journal_mode = wal;');
  }
}
 ?>
