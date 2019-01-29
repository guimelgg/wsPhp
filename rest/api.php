<?php
header("Content-Type:application/json");

include('db.php');
try
{
//if (isset($_GET['strDBName']) && $_GET['strDBName']!="" ) {
  $db=connectDB();
  if ($db) {
    $strOpcion=filter_input(INPUT_GET,'strOpcion');
    if (!$strOpcion){
      $strOpcion=filter_input(INPUT_POST,'strOpcion');
    }
    $strResultado="";
    switch ($strOpcion) {
      case "GetFechaServer":
        $strSql="SELECT strftime('%d/%m/%Y %H:%M',datetime()) Fecha";
        $result = $db->query($strSql);
        $strResultado=json_encode($result->fetchAll(PDO::FETCH_OBJ));
        break;
      case "GetWsConfig":
        $strResultado="localhost:8080/wsPhp/rest/api.php,wswcf.azurewebsites.net,REST";
        break;
      case "GetEsquemaInicial":

      break;
      default:
        $strSql='SELECT * FROM IngProducto';
        $result = $db->query($strSql);
        $strResultado=json_encode($result->fetchAll(PDO::FETCH_OBJ));
        break;
    }
    //SELECT name FROM sqlite_master WHERE type='table'
    /*$rows= count($result);
    echo "Number of rows: $rows";*/

    echo $strResultado;
    /*
    $LoginRS__query=sprintf("SELECT username, password FROM member WHERE username=%s AND password=%s",
    GetSQLValueString($_POST["username"], "text"), GetSQLValueString($password, "text"));
    */
    // close the database connection
    $db = NULL;
  }else {
    echo "Sin parametros";
  }

}
catch(PDOException $e)
{
  echo 'Exception : '.$e->getMessage();
}


?>
