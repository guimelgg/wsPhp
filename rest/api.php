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
    switch ($strOpcion) {
      case "GetFechaServer":
        $strSql="SELECT strftime('%d/%m/%Y %H:%M',datetime()) Fecha";
        break;
      default:
        $strSql='SELECT * FROM IngProducto';        
        break;
    }
    //SELECT name FROM sqlite_master WHERE type='table'
    /*$rows= count($result);
    echo "Number of rows: $rows";*/
    $result = $db->query($strSql);
    echo json_encode($result->fetchAll(PDO::FETCH_OBJ));
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
