<?php
$strDBName = filter_input(INPUT_GET,'strDBName');
if (!$strDBName) {
  $strDBName = filter_input(INPUT_POST,'strDBName');
}

include('db.php');
connectDB($strDBName);
//echo ($db ? "db SI" : "db NO");
if ($db) {
  include('clsEnt.php');
  switch ($strOpcion) {
    case "GetFechaServer":
    $strSql="SELECT strftime('%d/%m/%Y %H:%M',datetime('now','localtime')) Fecha";
    $STH = $db->prepare($strSql);
    $STH->execute();
    $result= $STH->fetch();
    $strResultado= $result["Fecha"];
    /*$result = $db->query($strSql);
    $strResultado=json_encode($result->fetchAll(PDO::FETCH_OBJ));*/
    break;
    case "pa_USUA_consultaparaUsuario":
    $result = pa_USUA_consultaparaUsuario($Accion,$Code1,$Parametro1,$Parametro2);
    $strResultado=json_encode($result->fetchAll(PDO::FETCH_OBJ));
    break;
    case "GetEsquema":
    $strSql="SELECT BDES_Script FROM paraBdEsquema WHERE BDES_Fecha>".$Parametro1;
    $result = $db->query($strSql);
    $strResultado=json_encode($result->fetchAll(PDO::FETCH_OBJ));
    break;
    case "pa_BDSI_consultaparaBdSincroniza":
    $strResultado = pa_BDSI_consultaparaBdSincroniza($Accion,$Code1,$Parametro1,$Parametro2);
    break;
    default:
    $strSql="SELECT * FROM IngProducto";
    $result = $db->query($strSql);
    $strResultado=json_encode($result->fetchAll(PDO::FETCH_OBJ));
    break;
  }
  $db = NULL;
}
?>
