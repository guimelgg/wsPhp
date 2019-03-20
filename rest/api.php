<?php
header("Content-Type:application/json");
if(!ob_start("ob_gzhandler")) ob_start();
try
{
  //SELECT name FROM sqlite_master WHERE type='table'
  /*$rows= count($result);
  echo "Number of rows: $rows";*/
  /*
  $LoginRS__query=sprintf("SELECT username, password FROM member WHERE username=%s AND password=%s",
  GetSQLValueString($_POST["username"], "text"), GetSQLValueString($password, "text"));
  */
  // close the database connection
  //if (isset($_GET['strDBName']) && $_GET['strDBName']!="" ) {
  $strOpcion=filter_input(INPUT_GET,'strOpcion');
  if (!$strOpcion){
    $strOpcion=filter_input(INPUT_POST,'strOpcion');
  }
  //$Accion
  $Accion = filter_input(INPUT_GET,'Accion');
  if (!$Accion) {
    $Accion = filter_input(INPUT_POST,'Accion');
  }
  //$Code1
  $Code1 = filter_input(INPUT_GET,'Code1');
  if (!$Code1) {
    $Code1 = filter_input(INPUT_POST,'Code1');
  }
  //$Parametro1
  $Parametro1 = filter_input(INPUT_GET,'Parametro1');
  if (!$Parametro1) {
    $Parametro1 = filter_input(INPUT_POST,'Parametro1');
  }
  //$Parametro2
  $Parametro2 = filter_input(INPUT_GET,'Parametro2');
  if (!$Parametro2) {
    $Parametro2 = filter_input(INPUT_POST,'Parametro2');
  }


  $strResultado="";

  switch($strOpcion) {//SIN BASE DE DATOS
    case "GetWsConfig":
      $strResultado="localhost/wsPhp/rest/api.php,wswcf.azurewebsites.net,REST";
    break;
    case "GetEsquemaInicial":
      $strBase=filter_input(INPUT_GET,'strBase');
      if (!$strBase){
        $strBase=filter_input(INPUT_POST,'strBase');
      }

      if ($strBase!=""){
        $strBase="database/".$strBase."bdScript.sql";
        $myfile= fopen($strBase,"r") or die("");
        $strResultado=fread($myfile,filesize($strBase));
        fclose($myfile);
      }
    break;
    case "sha1":
    $utfString = mb_convert_encoding($Accion,"UTF-16LE");
    $hashTag = sha1($utfString,true);
    $base64Tag = base64_encode($hashTag);
    echo $base64Tag . "<br />";


      /*$utfString = mb_convert_encoding($Accion,"UTF-16LE");
      $Paso1=sha1($Accion,true);
      //echo $Paso1;
      //echo "\r\n";
      echo base64_encode(bin2hex($Paso1));
*/
    break;
    default://CON BASE DE DATOS
      include('apidb.php');
    break;
  }
  echo $strResultado;
}
catch(PDOException $e)
{
  echo 'Exception : '.$e->getMessage();
}


?>
