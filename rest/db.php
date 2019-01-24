<?php

function connectDB(){
  $strDBName = filter_input(INPUT_GET,'strDBName');
  if (!$strDBName) {
    $strDBName = filter_input(INPUT_POST,'strDBName');
  }
  if ($strDBName) {
    $strPath = "database/".$strDBName;//patris.db
    $db = new PDO('sqlite:'.$strPath);
    return $db;
  }
      
}

 ?>
