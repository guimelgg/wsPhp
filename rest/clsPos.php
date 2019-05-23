<?php

//IngProducto
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
                if ($strTipo == "CONTENIDO") {
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
            $row= $stmt->fetch();
            $intAlmacenID=$row['AlmacenID'];            
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
                $row= $stmt->fetch();
                $intPtalID=$row['PTAL_PtalID'];
                $intCuotaMensual=$row['PTAL_CuotaMensual'];
                $intRm=$row['PTAL_Rm'];
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
            break;
        }
            if ($strAccion=="C" || $strAccion=="A" & $intCode > 0) {
                foreach ($xDoc->IngProducto->IngProductoVariable as $tblDetalle) {
                    switch ($tblDetalle['Accion']) {
                    case "A":
                        $strSql="INSERT INTO IngProductoVariable (PVAR_ProdID,PVAR_CodBarras,PVAR_Valor1,PVAR_Valor2,PVAR_Valor3,PVAR_UsuaID,PVAR_UsuaDate)
                        VALUES (?,?,?,?,?,?,$gstrFechaHoy)";
                        $stmt = $db->prepare($strSql);
                        $stmt->execute([$intCode,$tblDetalle['PVAR_CodBarras'],$tblDetalle['PVAR_Valor1'],$tblDetalle['PVAR_Valor2'],$tblDetalle['PVAR_Valor3'],$intUsrId]);
                        $intPvarID=$db->lastInsertId();
                    break;
                    case "C":
                        $strSql = "UPDATE IngProductoVariable SET PVAR_ProdID=:PVAR_ProdID,PVAR_CodBarras=:PVAR_CodBarras,PVAR_Valor1=:PVAR_Valor1
                        ,PVAR_Valor2=:PVAR_Valor2,PVAR_Valor3=:PVAR_Valor3,PVAR_Estatus=:PVAR_Estatus,PVAR_UsuaID=:PVAR_UsuaID
                        ,PVAR_UsuaDate=$gstrFechaHoy
                        WHERE PVAR_PvarID=:PVAR_PvarID";
                        $stmt = $db->prepare($strSql);
                        $stmt->bindParam(':PVAR_ProdID', $intCode, PDO::PARAM_INT);
                        $stmt->bindParam(':PVAR_CodBarras', $tblDetalle['PVAR_CodBarras'], PDO::PARAM_STR);
                        $stmt->bindParam(':PVAR_Valor1', $tblDetalle['PVAR_Valor1'], PDO::PARAM_STR);
                        $stmt->bindParam(':PVAR_Valor2', $tblDetalle['PVAR_Valor2'], PDO::PARAM_STR);
                        $stmt->bindParam(':PVAR_Valor3', $tblDetalle['PVAR_Valor3'], PDO::PARAM_STR);
                        $stmt->bindParam(':PVAR_Estatus', $tblDetalle['PVAR_Estatus'], PDO::PARAM_STR);
                        $stmt->bindParam(':PVAR_UsuaID', intval($intUsrId), PDO::PARAM_INT);
                        $stmt->bindParam(':PVAR_PvarID', $tblDetalle['PVAR_PvarID'], PDO::PARAM_INT);
                        $stmt->execute();
                    break;
                    case "B":
                        $strSql = "UPDATE IngProductoVariable SET PVAR_Estatus='B',PVAR_UsuaID=:PVAR_UsuaID
                        ,PVAR_UsuaDate=$gstrFechaHoy WHERE PVAR_PvarID=:PVAR_PvarID";
                        $stmt = $db->prepare($strSql);
                        $stmt->bindParam(':PVAR_UsuaID', intval($intUsrId), PDO::PARAM_INT);
                        $stmt->bindParam(':PVAR_PvarID', $tblDetalle['PVAR_PvarID'], PDO::PARAM_INT);
                        $stmt->execute();
                    break;
                    }
                }
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
    if ($intPvarID==0) {
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
//VtaListaDePrecio
function pa_LPRE_abcVtaListaDePrecio($intCode, $strXml, $intUsrId, $strIpAddress)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        $xDoc= new SimpleXMLElement($strXml);
        $tblNombre=$xDoc->VtaListaDePrecio;
        $strAccion=$tblNombre['Accion'];
        switch ($strAccion) {
          case "A":
            $strSql="INSERT INTO VtaListaDePrecio (LPRE_Nombre,LPRE_Desc,LPRE_MonedaID,LPRE_LineaID,LPRE_UsuaID,LPRE_UsuaDate)
            VALUES (?,?,?,?,?,$gstrFechaHoy)";
            $stmt = $db->prepare($strSql);
            $stmt->execute([$tblNombre['LPRE_Nombre'],$tblNombre['LPRE_Desc'],$tblNombre['LPRE_MonedaID'],$tblNombre['LPRE_LineaID'],$intUsrId]);
            $intCode=$db->lastInsertId();
          break;
          case "B":
            $strSql="UPDATE VtaListaDePrecio SET LPRE_Estatus = 'B' ,LPRE_UsuaDate=$gstrFechaHoy, LPRE_UsuaID=:LPRE_UsuaID
            WHERE LPRE_LpreID=:LPRE_LpreID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':LPRE_UsuaID', intval($intUsrId), PDO::PARAM_INT);
            $stmt->bindParam(':LPRE_LpreID', intval($intCode), PDO::PARAM_INT);
            $stmt->execute();
          break;
          case "C":
            $strSql="UPDATE VtaListaDePrecio SET LPRE_UsuaDate=$gstrFechaHoy ,LPRE_Nombre=:LPRE_Nombre,LPRE_Desc=:LPRE_Desc,LPRE_MonedaID=:LPRE_MonedaID,LPRE_LineaID=:LPRE_LineaID,LPRE_UsuaID=:LPRE_UsuaID
            WHERE LPRE_LpreID=:LPRE_LpreID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':LPRE_Nombre', $tblNombre['LPRE_Nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':LPRE_Desc', $tblNombre['LPRE_Desc'], PDO::PARAM_STR);
            $stmt->bindParam(':LPRE_MonedaID', intval($tblNombre['LPRE_MonedaID']), PDO::PARAM_INT);
            $stmt->bindParam(':LPRE_LineaID', intval($tblNombre['LPRE_LineaID']), PDO::PARAM_INT);
            $stmt->bindParam(':LPRE_UsuaID', intval($intUsrId), PDO::PARAM_INT);
            $stmt->bindParam(':LPRE_LpreID', intval($intCode), PDO::PARAM_INT);
            $stmt->execute();
          break;
        }
        if ($strAccion=="C" || $strAccion=="A") {
            //INICIO Detalle
            foreach ($xDoc->VtaListaDePrecio->VtaPrecio as $tblDetalle) {
                sVtaPrecioABC($tblDetalle['Accion'], $intCode, $tblDetalle['PREC_ProdID'], $tblDetalle['PREC_Precio'], $tblDetalle['PREC_PrecID'], $intUsrId, $tblDetalle['PREC_Descuento']);
            }      
            //FIN Detalle
        }
    }
    return $intCode;    
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
//InvFisico
function pa_INFI_abcInvFisico($intCode, $strXml, $intUsrId, $strIpAddress)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        $xDoc= new SimpleXMLElement($strXml);
        $tblNombre=$xDoc->InvFisico;
        $strAccion=$tblNombre['Accion'];
        switch ($strAccion) {
          case "A":
            $intCode=fInsertInvFisico($tblNombre['INFI_AlmaId'],$tblNombre['INFI_Fecha'],$tblNombre['INFI_Obs'],$intUsrId);            
          break;
          case "B":
            $strSql="UPDATE InvFisico SET INFI_Estatus = 'B' ,INFI_UsuaDate=$gstrFechaHoy, INFI_UsuaID=:INFI_UsuaID
            WHERE INFI_InfiId=:INFI_InfiId";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':INFI_UsuaID', intval($intUsrId), PDO::PARAM_INT);
            $stmt->bindParam(':INFI_InfiId', intval($intCode), PDO::PARAM_INT);
            $stmt->execute();
            //Detalle
            $strSql="UPDATE InvFisicoDet SET IFDT_Estatus = 'B' ,IFDT_UsuaDate=$gstrFechaHoy, IFDT_UsuaID=:IFDT_UsuaID
            WHERE IFDT_InfiId=:IFDT_InfiId";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':IFDT_UsuaID', intval($intUsrId), PDO::PARAM_INT);
            $stmt->bindParam(':IFDT_InfiId', intval($intCode), PDO::PARAM_INT);
            $stmt->execute();            
          break;
          case "C":
            $strSql="UPDATE InvFisico SET INFI_AlmaId=:INFI_AlmaId,INFI_Fecha=:INFI_Fecha,INFI_Obs=:INFI_Obs,INFI_UsuaID=:INFI_UsuaID
            ,INFI_UsuaDate=$gstrFechaHoy WHERE INFI_InfiId=:INFI_InfiId";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':INFI_AlmaId', intval($tblNombre['INFI_AlmaId']), PDO::PARAM_INT);
            $stmt->bindParam(':INFI_Fecha', $tblNombre['INFI_Fecha'], PDO::PARAM_STR);
            $stmt->bindParam(':INFI_Obs', $tblNombre['INFI_Obs'], PDO::PARAM_STR);
            $stmt->bindParam(':INFI_UsuaID', intval($intUsrId), PDO::PARAM_INT);
            $stmt->bindParam(':INFI_InfiId', intval($intCode), PDO::PARAM_INT);                                    
            $stmt->execute();
          break;
          case "ACTKARDEX" || "ABRIR":
            //Obtiene los IDs de Entrada y Salida
            $intEntradaId=0; $intSalidaId=0;
            $strSql = "SELECT MAX(INFI_AEntradaId) AS INFI_AEntradaId,MAX(INFI_ASalidaId) AS INFI_ASalidaId FROM InvFisico WHERE INFI_Estatus<>'B' 
            AND INFI_AlmaId=:INFI_AlmaId AND INFI_Fecha=:INFI_Fecha";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':INFI_AlmaId', $intval($tblNombre['INFI_AlmaId']), PDO::PARAM_INT);  
            $stmt->bindParam(':INFI_Fecha', $tblNombre['INFI_Fecha'], PDO::PARAM_STR);
            $stmt->execute();   
            $row= $stmt->fetch();
            if($row){
                $intEntradaId=intval($row['INFI_AEntradaId']);
                $intSalidaId=intval($row['INFI_ASalidaId']);
            }
            if ($strAccion=="ABRIR") {
                $strSql = "UPDATE InvFisico SET INFI_Estatus='A'
                ,INFI_UsuaDate=$gstrFechaHoy ,INFI_UsuaID=:INFI_UsuaID
                WHERE INFI_AlmaId=:INFI_AlmaId
                AND INFI_Fecha=:INFI_Fecha AND INFI_Estatus='V';
                UPDATE InvMovimientoDet SET MODT_Estatus = 'B' 
                ,MODT_UsuaDate=$gstrFechaHoy ,MODT_UsuaID=$intUsrId 
                WHERE (MODT_MoinID =$intEntradaId OR MODT_MoinID =$intSalidaId ) AND MODT_Estatus <> 'B';
                UPDATE InvMovimiento SET MOIN_Fecha=:MOIN_Fecha 
                ,MOIN_UsuaDate=$gstrFechaHoy, MOIN_UsuaID=$intUsrId , MOIN_Estatus='A' 
                WHERE (MOIN_MoinID =$intEntradaId OR MOIN_MoinID =$intSalidaId) AND MOIN_Estatus <> 'B';";
                $stmt = $db->prepare($strSql);
                $stmt->bindParam(':INFI_AlmaId', intval($tblNombre['INFI_AlmaId']), PDO::PARAM_INT);
                $stmt->bindParam(':INFI_Fecha', $tblNombre['INFI_Fecha'], PDO::PARAM_STR);                
                $stmt->bindParam(':INFI_UsuaID', intval($intUsrId), PDO::PARAM_INT);                
                $stmt->bindParam(':INFI_Fecha', $tblNombre['INFI_Fecha'], PDO::PARAM_STR);
                $stmt->execute();  
                                                                
            } else {
                //Obtiene la Existencia que habia a X fecha
                sTempExiPXC($tblNombre['INFI_AlmaId'], $tblNombre['INFI_Fecha'], $intEntradaId, $intSalidaId);
                $strSql="CREATE TEMP VIEW TempInvFisico AS
                SELECT IFDT_IfdtId IfdtId,INFI_InfiId InfiId,IFDT_ProdId ProdId,IFDT_ContId ContId,ifnull(TempExiPXC.Existencia,0) Existencia,IFDT_PvarID PvarID
                FROM InvFisicoDet INNER JOIN InvFisico ON InvFisico.INFI_InfiId=InvFisicoDet.IFDT_InfiId
                AND InvFisico.INFI_AlmaId=:INFI_AlmaId AND InvFisico.INFI_Fecha=:INFI_Fecha AND InvFisico.INFI_Estatus<>'B' AND InvFisicoDet.IFDT_Estatus='A'
                LEFT JOIN TempExiPXC ON InvFisicoDet.IFDT_ProdID=TempExiPXC.ProdID AND InvFisicoDet.IFDT_PvarID=TempExiPXC.PvarID AND InvFisicoDet.IFDT_ContId=TempExiPXC.ContID;
                INSERT OR REPLACE INTO InvFisicoDet (IFDT_IfdtId,IFDT_InfiId,IFDT_ProdId,IFDT_ContId,IFDT_Cantidad,IFDT_PvarID,IFDT_UsuaDate)
                SELECT IfdtId,InfiId,ProdId,ContId,Existencia,PvarID,$gstrFechaHoy FROM TempInvFisico;";
                $stmt = $db->prepare($strSql); 
                $stmt->bindParam(':INFI_AlmaId', intval($tblNombre['INFI_AlmaId']), PDO::PARAM_INT);
                $stmt->bindParam(':INFI_Fecha', $tblNombre['INFI_Fecha'], PDO::PARAM_STR);
                $stmt->execute();  

                // $strSql = "UPDATE InvFisicoDet
                // SET InvFisicoDet.IFDT_Kardex=0, InvFisicoDet.IFDT_UsuaDate=$gstrFechaHoy
                //  FROM  InvFisicoDet INNER JOIN InvFisico ON InvFisico.INFI_InfiId=InvFisicoDet.IFDT_InfiId
                //  WHERE InvFisico.INFI_AlmaId=".$tblNombre['INFI_AlmaId']." AND InvFisico.INFI_Fecha=:INFI_Fecha AND InvFisico.INFI_Estatus<>'B' AND InvFisicoDet.IFDT_Estatus='A'";
                // $stmt = $db->prepare($strSql); 
                // $stmt->bindParam(':INFI_Fecha', $tblNombre['INFI_Fecha'], PDO::PARAM_STR);
                // $stmt->execute();  
                // $strSql = "UPDATE InvFisicoDet
                // SET InvFisicoDet.IFDT_Kardex=TempExiPXC.Existencia, InvFisicoDet.IFDT_UsuaDate=$gstrFechaHoy
                // FROM  InvFisicoDet INNER JOIN InvFisico ON InvFisico.INFI_InfiId=InvFisicoDet.IFDT_InfiId
                // INNER JOIN TempExiPXC ON InvFisicoDet.IFDT_ProdID=TempExiPXC.ProdID AND InvFisicoDet.IFDT_PvarID=TempExiPXC.PvarID AND InvFisicoDet.IFDT_ContId=TempExiPXC.ContID
                // WHERE InvFisico.INFI_AlmaId=".$tblNombre['INFI_AlmaId']
                // ." AND InvFisico.INFI_Fecha=:INFI_Fecha AND InvFisico.INFI_Estatus<>'B' AND InvFisicoDet.IFDT_Estatus='A'";
                // $stmt = $db->prepare($strSql); 
                // $stmt->bindParam(':INFI_Fecha', $tblNombre['INFI_Fecha'], PDO::PARAM_STR);
                // $stmt->execute();  
                if ($tblNombre['OPCION'] == "CIERRE") {
                    $intNoReportados=0;
                    $strSql = "SELECT MAX(INFI_infiid) AS INFI_infiid FROM InvFisico WHERE INFI_Estatus<>'B' AND INFI_AlmaId=" . $tblNombre['INFI_AlmaId'] 
                    ." AND INFI_Fecha=:INFI_Fecha AND INFI_Obs='PRODUCTOS NO REPORTADOS'";
                    $stmt = $db->prepare($strSql); 
                    $stmt->bindParam(':INFI_Fecha', $tblNombre['INFI_Fecha'], PDO::PARAM_STR);
                    $stmt->execute();   
                    $intNoReportados=0;
                    $row= $stmt->fetch();
                    if($row){
                        $intNoReportados=intval($row['INFI_Infiid']);
                    }                    
                    //PRODUCTOS NO REPORTADOS
                    $strSqlPtNoRpt= " FROM TempExiPXC WHERE TempExiPXC.Existencia<>0
                     AND TempExiPXC.ProdID NOT IN (SELECT IFDT_ProdId FROM InvFisico INNER JOIN InvFisicoDet ON InvFisico.INFI_InfiId=InvFisicoDet.IFDT_InfiId
                     WHERE IFDT_ProdId=TempExiPXC.ProdID AND IFDT_ContId=TempExiPXC.ContID AND IFDT_PvarID=TempExiPXC.PvarID AND InvFisicoDet.IFDT_Estatus='A'
                     AND InvFisico.INFI_AlmaId=:INFI_AlmaId
                     AND InvFisico.INFI_Fecha=:INFI_Fecha 
                     AND InvFisico.INFI_Estatus<>'B'
                     AND InvFisico.INFI_InfiId<>$intNoReportados )";
                    if ($intNoReportados == 0){
                        $strSql = "SELECT * " . $strSqlPtNoRpt;
                        $stmt = $db->prepare($strSql); 
                        $stmt->bindParam(':INFI_Fecha', $tblNombre['INFI_Fecha'], PDO::PARAM_STR);
                        $stmt->bindParam(':INFI_AlmaId', intval($tblNombre['INFI_AlmaId']), PDO::PARAM_INT);
                        $stmt->execute();  
                        $intRow=0; 
                        $row= $stmt->fetch();
                        if($row){
                           $intRow.=1;
                        }                        
                        if ($intRow>0){
                            $intNoReportados=fInsertInvFisico($tblNombre['INFI_AlmaId'],$tblNombre['INFI_Fecha'],"PRODUCTOS NO REPORTADOS",$intUsrId);            
                        }
                    } else {//ELIMINAR EL DETALLE DE PRODUCTOS NO REPORTADOS
                        $strSql="UPDATE InvFisicoDet SET IFDT_Estatus='B', IFDT_UsuaDate=$gstrFechaHoy , IFDT_UsuaID=:IFDT_UsuaID WHERE IFDT_InfiID=:IFDT_InfiID";
                        $stmt = $db->prepare($strSql); 
                        $stmt->bindParam(':INFI_UsuaID', intval($intUsrId), PDO::PARAM_INT);                
                        $stmt->bindParam(':IFDT_InfiID', $intNoReportados, PDO::PARAM_INT);
                        $stmt->execute();  
                    }
                    if ($intNoReportados >0){//INSERTA LOS PRODUCTOS NO REPORTADOS Y CON VALOR
                        $strSql = "INSERT INTO InvFisicoDet (IFDT_InfiId,IFDT_ProdId,IFDT_ContId,IFDT_Cantidad,IFDT_UsuaID,IFDT_PvarID,IFDT_Kardex,IFDT_UsuaDate) 
                        SELECT $intNoReportados ,TempExiPXC.ProdID,TempExiPXC.ContID,0,$intUsrId,TempExiPXC.PvarID,TempExiPXC.Existencia,".$gstrFechaHoy.strSqlPtNoRpt;
                        $stmt = $db->prepare($strSql); 
                        $stmt->execute();  
                    }
                    //Productos con diferencias entre el Fisico y kardex
                    $strSql = "UPDATE InvMovimientoDet SET MODT_Estatus = 'B' 
                    , MODT_UsuaDate=$gstrFechaHoy , MODT_UsuaID=$intUsrId
                     WHERE MODT_MoinID = -99";
                    $stmt = $db->prepare($strSql); 
                    $stmt->execute();                       
                    
                    $strSql = "INSERT INTO InvMovimientoDet (MODT_MoinID,MODT_ProdID,MODT_ContID,MODT_Cantidad,MODT_UsuaID,MODT_PvarID,MODT_UsuaDate)
                    SELECT -99,InvFisicoDet.IFDT_ProdId,InvFisicoDet.IFDT_ContId,SUM(InvFisicoDet.IFDT_Cantidad)-MAX(InvFisicoDet.IFDT_Kardex),$intUsrId 
                    ,InvFisicoDet.IFDT_PvarID,$gstrFechaHoy
                    FROM InvFisico INNER JOIN InvFisicoDet ON InvFisico.INFI_InfiId=InvFisicoDet.IFDT_InfiId
                    WHERE InvFisicoDet.IFDT_Estatus='A'
                    AND InvFisico.INFI_AlmaId=:INFI_AlmaId
                    AND InvFisico.INFI_Fecha=:INFI_Fecha AND INFI_Estatus<>'B'
                    GROUP BY InvFisicoDet.IFDT_ProdId,InvFisicoDet.IFDT_PvarID,InvFisicoDet.IFDT_ContId
                    HAVING SUM(InvFisicoDet.IFDT_Kardex)<>SUM(InvFisicoDet.IFDT_Cantidad)";
                    $stmt = $db->prepare($strSql); 
                    $stmt->bindParam(':INFI_AlmaId', intval($tblNombre['INFI_AlmaId']), PDO::PARAM_INT);
                    $stmt->bindParam(':INFI_Fecha', $tblNombre['INFI_Fecha'], PDO::PARAM_STR);
                    $stmt->execute();     
                    //ENTRADAS
                    $strSql = "SELECT COUNT(*) AS Cuantos FROM InvMovimientoDet WHERE MODT_Estatus <> 'B' AND MODT_Cantidad>0 AND MODT_MoinID=-99";
                    $stmt = $db->prepare($strSql);                    
                    $stmt->execute();  
                    $intCuantos=0;
                    $row= $stmt->fetch();
                    if($row){
                        $intCuantos=intval($row['Cuantos']);    
                    }                     
                    if ($intCuantos>0){
                        if ($intEntradaId==0){
                            $intCATA_CataID=0;
                            $strSql = "SELECT CATA_CataID FROM paraCatalogo WHERE CATA_Estatus='A' AND CATA_Tipo='ALMACENMOV' AND CATA_Desc1='ENT.AJUSTE'";
                            $stmt = $db->prepare($strSql);                    
                            $stmt->execute(); 
                            $row= $stmt->fetch();
                            if($row){
                                $intCATA_CataID=intval($row['CATA_CataID']);    
                            }                                                         
                            if ($intCATA_CataID>0){
                                $intEntrada=fInsertInvMovimiento(intval($tblNombre['INFI_AlmaId']),$intCATA_CataID,$tblNombre['INFI_Fecha'],"AJUSTES INVENTARIO FISICO",$intCode,$intUsrId,"A");
                            }
                        }else {
                            $strSql = "UPDATE InvMovimientoDet SET MODT_Estatus = 'B' 
                            , MODT_UsuaDate=$gstrFechaHoy , MODT_UsuaID=".$intUsrId 
                             ." WHERE MODT_MoinID = ". $intEntradaId;
                             $stmt = $db->prepare($strSql);                    
                             $stmt->execute();                                                           
                        }
                        $strSql = "UPDATE InvMovimientoDet SET MODT_MoinID =" . $intEntradaId . ", MODT_UsuaDate=$gstrFechaHoy 
                         WHERE MODT_MoinID=-99 AND MODT_Estatus <> 'B' AND MODT_Cantidad>0";
                         $stmt = $db->prepare($strSql);                    
                         $stmt->execute();                                                           
                    }
                    //SALIDAS
                    $strSql = "SELECT COUNT(*) AS Cuantos FROM InvMovimientoDet WHERE MODT_Estatus <> 'B' AND MODT_Cantidad<0 AND MODT_MoinID=-99";
                    $stmt = $db->prepare($strSql);                    
                    $stmt->execute();  
                    $intCuantos=0; 
                    $row= $stmt->fetch();
                    if($row){
                        $intCuantos=intval($row['Cuantos']);    
                    }                    
                    if ($intCuantos>0){
                        if ($intSalidaId==0){
                            $intCATA_CataID=0;
                            $strSql = "SELECT CATA_CataID FROM paraCatalogo WHERE CATA_Estatus='A' AND CATA_Tipo='ALMACENMOV' AND CATA_Desc1='SAL.AJUSTE'";
                            $stmt = $db->prepare($strSql);                    
                            $stmt->execute();           
                            $row= $stmt->fetch();
                            if($row){
                                $intCATA_CataID=intval($row['CATA_CataID']);    
                            }                                               
                            if ($intCATA_CataID>0){
                                $intSalidaId=fInsertInvMovimiento(intval($tblNombre['INFI_AlmaId']),$intCATA_CataID,$tblNombre['INFI_Fecha'],"AJUSTES INVENTARIO FISICO",$intCode,$intUsrId,"A");
                            }
                        }else {
                            $strSql = "UPDATE InvMovimientoDet SET MODT_Estatus = 'B' 
                            , MODT_UsuaDate=$gstrFechaHoy , MODT_UsuaID=".$intUsrId 
                             ." WHERE MODT_MoinID = ". $intSalidaId;
                             $stmt = $db->prepare($strSql);                    
                             $stmt->execute();                                                           
                        }
                        $strSql = "UPDATE InvMovimientoDet SET MODT_MoinID =" . $intSalidaId . ", MODT_UsuaDate=$gstrFechaHoy 
                         WHERE MODT_MoinID=-99 AND MODT_Estatus <> 'B' AND MODT_Cantidad<0";
                         $stmt = $db->prepare($strSql);                    
                         $stmt->execute();                                                           
                    }  
                    // CREA REFERENCIA ENTRE INV FISICO Y MOVIMIENTO
                    $strSql = "UPDATE InvFisico 
                     SET INFI_AEntradaId=" . $intEntradaId .
                    ",INFI_ASalidaId=" . intSalidaId .
                    ",INFI_Estatus='V'
                    ,INFI_UsuaDate=$gstrFechaHoy , INFI_UsuaID=" . $intUsrId .
                    " WHERE INFI_AlmaId=" . $tblNombre['INFI_AlmaId'] .
                    " AND INFI_Fecha=" . $tblNombre['INFI_Fecha'] . " AND INFI_Estatus<>'B'";
                    $stmt = $db->prepare($strSql);                    
                    $stmt->execute();     
                    //CAMBIA EL ESTATUS A V EN LOS MOVIMIENTOS DE ENTRADA Y SALIDA
                    $strSql = "UPDATE InvMovimiento SET MOIN_Estatus='V',
                     MOIN_UsuaDate=$gstrFechaHoy, MOIN_UsuaID=" . $intUsrId .
                    " WHERE (MOIN_MoinID =" . $intEntradaId . " OR MOIN_MoinID =" . $intSalidaId . ") AND MOIN_Estatus = 'A'";
                    $stmt = $db->prepare($strSql);                    
                    $stmt->execute(); 
                    //ACTUALIZA LA EXISTENCIA EN ALMACENES  
                    pa_PTAL_abcInvProductoAlmacen($tblNombre['INFI_AlmaId'], '<InvProductoAlmacen Accion="EXIPXC" />', $intUsrId, $strIpAddress);
                }
            }
          break;
          default:          
          break;
        }
        if ($strAccion=="C" || $strAccion=="A") {
            //INICIO Detalle
            foreach ($xDoc->InvFisico->InvFisicoDet as $tblDetalle) {
                switch ($tblDetalle['Accion']) {
                    case "A":
                    $strSql="INSERT INTO InvFisicoDet (IFDT_InfiId,IFDT_ProdId,IFDT_ContId,IFDT_Cantidad,IFDT_UsuaID,IFDT_PvarID,IFDT_Obs,IFDT_UsuaDate)
                      VALUES (?,?,?,?,?,?,?,$gstrFechaHoy)";
                      $stmt = $db->prepare($strSql);
                      $stmt->execute([intval($intCode),$tblDetalle['IFDT_ProdId'],$tblDetalle['IFDT_ContId'],$tblDetalle['IFDT_Cantidad'],$intUsrId,$tblDetalle['IFDT_PvarID'],$tblDetalle['IFDT_Obs']]);
                      break;
                    case "C":
                      $strSql="UPDATE InvFisicoDet SET IFDT_InfiId=:IFDT_InfiId,IFDT_ProdId=:IFDT_ProdId,IFDT_ContId=:IFDT_ContId,IFDT_Cantidad=:IFDT_Cantidad,IFDT_UsuaID=:IFDT_UsuaID
                      ,IFDT_PvarID=:IFDT_PvarID,IFDT_UsuaDate=$gstrFechaHoy,IFDT_Obs=:IFDT_Obs
                       WHERE IFDT_IfdtId=:IFDT_IfdtId" ;
                      $stmt = $db->prepare($strSql);
                      $stmt->bindParam(':IFDT_InfiId', intval($intCode), PDO::PARAM_INT);
                      $stmt->bindParam(':IFDT_ProdId', intval($tblDetalle['IFDT_ProdId']), PDO::PARAM_INT);
                      $stmt->bindParam(':IFDT_ContId', intval($tblDetalle['IFDT_ContId']), PDO::PARAM_INT);
                      $stmt->bindParam(':IFDT_Cantidad', $tblDetalle['IFDT_Cantidad'], PDO::PARAM_STR);
                      $stmt->bindParam(':IFDT_UsuaID', intval($intUsrId), PDO::PARAM_INT);
                      $stmt->bindParam(':IFDT_PvarID', intval($tblDetalle['IFDT_PvarID']), PDO::PARAM_INT);
                      $stmt->bindParam(':IFDT_Obs', $tblDetalle['IFDT_Obs'], PDO::PARAM_STR);
                      $stmt->bindParam(':IFDT_IfdtId', intval($tblDetalle['IFDT_IfdtId']), PDO::PARAM_INT);
                      $stmt->execute();
                      break;
                    case "B":
                      $strSql="UPDATE InvFisicoDet SET IFDT_UsuaDate=$gstrFechaHoy,IFDT_Estatus='B',IFDT_UsuaID=:IFDT_UsuaID WHERE IFDT_IfdtId=:IFDT_IfdtId";
                      $stmt = $db->prepare($strSql);
                      $stmt->bindParam(':IFDT_UsuaID', intval($intUsrId), PDO::PARAM_INT);
                      $stmt->bindParam(':IFDT_IfdtId', intval($tblDetalle['IFDT_IfdtId']), PDO::PARAM_INT);
                      $stmt->execute();
                      break;
                  }
            }      
            //FIN Detalle
        }
    }
    return $intCode;    
}
function fInsertInvFisico($strINFI_AlmaId, $strINFI_Fecha, $strINFI_Obs, $intUsrId)
{
    global $db;
    global $gstrFechaHoy;
    $intResultado=0;
    if ($db) {
        $intFolio=0;
        $strSql="SELECT MAX(INFI_Folio) AS Resultado FROM InvFisico WHERE INFI_AlmaId=:INFI_AlmaId";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':INFI_AlmaId', intval($strINFI_AlmaId), PDO::PARAM_INT);  
        $stmt->execute(); 
        $row= $stmt->fetch();
        if($row){
            $intFolio= intval($row['Resultado'])+1;
        }        
        $strSql="INSERT INTO InvFisico (INFI_AlmaId,INFI_Folio,INFI_Fecha,INFI_Obs,INFI_UsuaID,INFI_UsuaDate)
        VALUES (?,?,?,?,?,$gstrFechaHoy)";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$strINFI_AlmaId,$intFolio,$strINFI_Fecha,$strINFI_Obs,$intUsrId]); 
        $intResultado=$db->lastInsertId();       
    }
    return $intResultado;
}
function sTempExiPXC($strINFI_AlmaId, $strINFI_Fecha, $intEntradaId, $intSalidaId, $intProdId, $intPvarId)
{
    //El estatus de P es pendiente de autorización y no afecta existencia
    //Obtiene la Existencia que habia a X fecha
    global $db;
    global $gstrFechaHoy;
    
    if ($db) {
        $strSql = "DELETE FROM TempExiPXC";
        $stmt = $db->prepare($strSql);
        $stmt->execute();           

        $strSql = "INSERT INTO TempExiPXC (PvarID, ProdID, ContID, Existencia)
        SELECT InvMovimientoDet.MODT_PvarID, InvMovimientoDet.MODT_ProdID, InvMovimientoDet.MODT_ContID, SUM(InvMovimientoDet.MODT_Cantidad) AS Existencia
        FROM (InvMovimientoDet INNER JOIN InvMovimiento ON InvMovimiento.MOIN_MoinId = InvMovimientoDet.MODT_MoinID)
        WHERE InvMovimientoDet.MODT_Estatus <> 'B' AND InvMovimiento.MOIN_Estatus <> 'B' AND InvMovimiento.MOIN_Estatus <> 'P' AND InvMovimiento.MOIN_AlmacenCataID =".$strINFI_AlmaId;
        
        if (strlen($strINFI_Fecha)>0){    $strSql .= "AND (InvMovimiento.MOIN_Fecha < ". $strINFI_Fecha.")"; }
        if ($intEntradaId>0 && $intSalidaId>0){    $strSql .= " AND (InvMovimiento.MOIN_moinId not in (".$intEntradaId.",".$intSalidaId."))"; }
        if ($intProdId > 0) {    $strSql .= " AND (InvMovimientoDet.MODT_ProdID=".$intProdId & ")"; }
        if ($intPvarId > 0) {    $strSql .= " AND (InvMovimientoDet.MODT_PvarID=".$intPvarId & ")"; }        
        $strSql .= " GROUP BY InvMovimientoDet.MODT_PvarID, InvMovimientoDet.MODT_ProdID, InvMovimientoDet.MODT_ContID";
        $stmt = $db->prepare($strSql);
        $stmt->execute();                   
    }
    return 0;
}
//InvMovimiento
function pa_MOIN_abcInvMovimiento($intCode, $strXml, $intUsrId, $strIpAddress)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        $bolAfectoExi=FALSE;
        $intAlmacenId=0;
        $intAlmacenIdTraspaso=0;
        $intContIDTraspaso=0;

        $strSqlEncCampos="";
        $strSigno="";
        $bolReubicacion=FALSE;        

        $xDoc= new SimpleXMLElement($strXml);
        $tblNombre=$xDoc->InvMovimiento;
        $strAccion=$tblNombre['Accion'];
        $strMOIN_Estatus="A";
        if ($tblNombre['MOIN_Estatus']){
            $strMOIN_Estatus=$tblNombre['MOIN_Estatus'];
        }
        $intAlmacenId=$tblNombre['MOIN_AlmacenCataID'];
        //Si es traspaso de almacén recuperamos el Id de destino
        if (($tblNombre['AlmDestino']) && (intval($tblNombre['AlmDestino']))>0){
            $intAlmacenIdTraspaso = intval($tblNombre['AlmDestino']);
            if ($tblNombre['ContDestino']){
                $intContIDTraspaso=intval($tblNombre['ContDestino']);
            }else {
                $intUbicID=0;
                $strXmlUbic="";
                $stmt = pa_CONT_ConsultaInvContenedor("VALCONTENEDOR", $intAlmacenIdTraspaso, "1","");
                $row= $stmt->fetch();
                if($row){
                    $intContIDTraspaso= $row['CONT_ContID'];
                }else {
                    $stmt = pa_UBIC_ConsultaInvUbicacion("DEFAULT", $intAlmacenIdTraspaso,"","");
                    $row= $stmt->fetch();
                    if($row){
                        $intUbicID=intval($tblNombre['UBIC_UbicCataID']);
                    }else {
                        $strXmlUbic = '<InvUbicacion Accion="A" UBIC_Clave="1" UBIC_AlmaID="'.$intAlmacenIdTraspaso.'" UBIC_L1="" UBIC_L2="" UBIC_L3="" UBIC_L4="" />';
                         $intUbicID= pa_UBIC_abcInvUbicacion(0, $strXmlUbic, $intUsrId, $strIpAddress);                         
                    }
                    if($intUbicID > 0){
                        $strXmlUbic = '<InvContenedor Accion="A" CONT_clave="1" CONT_ubicCataID="'.$intUbicID.'" CONT_peso="" CONT_L1="" CONT_L2="" CONT_L3="" CONT_L4="" CONT_L5="" />';
                        $intContIDTraspaso = pa_CONT_abcInvContenedor(0, $strXmlUbic, $intUsrId, $strIpAddress);                                                
                    }
                }                                
            }            
        }
        //Obtenemos el signo de las operaciones Entrada + Salida -
        if ($strAccion != "B"){
            $strSql = "SELECT CATA_Desc2 FROM paraCatalogo WHERE CATA_CataID = ?"; 
            $stmt = $db->prepare($strSql);                      
            $stmt->execute([$tblNombre['MOIN_TipoMovCataID']]);
            $row= $stmt->fetch();
            if($row){
                if ($row['CATA_Desc2']=="S"){
                    $strSigno = "-";
                }else if ($row['CATA_Desc2']=="R"){
                    $strSigno = "-";
                    $bolReubicacion = TRUE;
                }
            }            
        }
        //Si es C o B AFECTA LA EXISTENCIA ACTUAL
        if (($strAccion =="C" && $xDoc->InvMovimiento->InvMovimientoDet) || $strAccion=="B"){
            sMoinAfectaExistencia($intCode, $intAlmacenId, "-");            
            $bolAfectoExi = TRUE;
        }
        //Inserta el Encabezado
        switch ($strAccion) {
          case "A":
            $intCode = fInsertInvMovimiento($tblNombre['MOIN_AlmacenCataID'],$tblNombre['MOIN_TipoMovCataID'],$tblNombre['MOIN_Fecha'],$tblNombre['MOIN_Obs'],$tblNombre['MOIN_Referencia'],$intUsrId, $strMOIN_Estatus);            
            $bolAfectoExi=TRUE;
          break;
          case "B":
            $strSql="UPDATE InvMovimiento SET MOIN_Estatus= 'B' ,MOIN_UsuaDate=$gstrFechaHoy, MOIN_UsuaID=? WHERE MOIN_MoinId =?";
            $stmt = $db->prepare($strSql);
            $stmt->execute([$intUsrId,$intCode]);
          break;
          case "C":
            $strSql = "UPDATE InvMovimiento SET 
            MOIN_Fecha=?,MOIN_Obs=?,MOIN_Referencia=?,MOIN_UsuaID=?
            ,MOIN_UsuaDate=$gstrFechaHoy,MOIN_Estatus=? WHERE MOIN_MoinId=?";
            $stmt = $db->prepare($strSql);
            $stmt->execute([$tblNombre['MOIN_Fecha'],$tblNombre['MOIN_Obs'],$tblNombre['MOIN_Referencia'],$intUsrId,$strMOIN_Estatus,$intCode]);            
          break;
        }
        if ($strAccion=="C" || $strAccion=="A") {
            //INICIO Detalle
            foreach ($xDoc->InvMovimiento->InvMovimientoDet as $tblDetalle) {
                //Creamos PvarID
                if ($tblDetalle['MODT_PvarID']==0 && $tblDetalle['Valor1'] != "" ){
                    $tblDetalle['MODT_PvarID'] = fInsertIngProductoVariable($tblDetalle['MODT_ProdID'], "", $tblDetalle['Valor1'], $tblDetalle['Valor2'], "", $intUsrId);
                }
                switch ($tblDetalle['Accion']) {
                  case "A":
                  $strSql="INSERT INTO InvMovimientoDet (MODT_MoinID,MODT_ProdID,MODT_ContID,MODT_Cantidad,MODT_Costo,MODT_UsuaID,MODT_PvarID,MODT_ReferID,MODT_Obs,MODT_UsuaDate)
                    VALUES (?,?,?,?,?,?,?,?,?,$gstrFechaHoy)";
                    $stmt = $db->prepare($strSql);
                    $stmt->execute([intval($intCode),$tblDetalle['MODT_ProdID'],$tblDetalle['MODT_ContID'],$tblDetalle['MODT_Cantidad'],$tblDetalle['MODT_Costo'],$intUsrId,$tblDetalle['MODT_PvarID'],$tblDetalle['MODT_ReferID'],$tblDetalle['MODT_Obs']]);
                    if ($bolReubicacion){
                        $intReferencia=$db->lastInsertId();
                        $strSql = "INSERT INTO InvMovimientoDet (MODT_MoinID,MODT_ProdID,MODT_ContID,MODT_Cantidad,MODT_Costo,MODT_UsuaID,MODT_PvarID,MODT_ReferID,MODT_Obs,MODT_Estatus,MODT_UsuaDate)
                        VALUES (?,?,?,?,?,?,?,?,?,?,$gstrFechaHoy)";
                        $stmt = $db->prepare($strSql);
                        $stmt->execute([intval($intCode),$tblDetalle['MODT_ProdID'],$tblDetalle['MODT_ContId2'],$tblDetalle['MODT_Cantidad'],$tblDetalle['MODT_Costo'],$intUsrId,$tblDetalle['MODT_PvarID'],$intReferencia,$tblDetalle['MODT_Obs'],"H"]);                        
                    }                    
                    break;
                  case "C":
                    $strSql ="UPDATE InvMovimientoDet SET 
                    MODT_MoinID=?,MODT_ProdID=?,MODT_ContID=?,MODT_Cantidad=?,MODT_Costo=?,MODT_UsuaID=?,MODT_PvarID=?,MODT_UsuaDate=$gstrFechaHoy
                    ,MODT_ReferID=?,MODT_Obs=?
                    WHERE MODT_modtID=?";
                    $stmt = $db->prepare($strSql);
                    $stmt->execute([intval($intCode),$tblDetalle['MODT_ProdID'],$tblDetalle['MODT_ContID'],$tblDetalle['MODT_Cantidad'],$tblDetalle['MODT_Costo'],$intUsrId,$tblDetalle['MODT_PvarID'],$tblDetalle['MODT_ReferID'],$tblDetalle['MODT_Obs'],$tblDetalle['MODT_modtID']]);
                    if ($bolReubicacion){
                        $strSql ="UPDATE InvMovimientoDet SET 
                        MODT_ProdID=?,MODT_ContID=?,MODT_Cantidad=?,MODT_Costo=?,MODT_UsuaID=?,MODT_PvarID=?,MODT_UsuaDate=$gstrFechaHoy
                        ,MODT_Obs=?
                        WHERE MODT_Estatus='H' AND MODT_ReferID=? AND MODT_MoinID=?";
                        $stmt = $db->prepare($strSql);
                        $stmt->execute([$tblDetalle['MODT_ProdID'],$tblDetalle['MODT_ContId2'],$tblDetalle['MODT_Cantidad'],$tblDetalle['MODT_Costo'],$intUsrId,$tblDetalle['MODT_PvarID'],$tblDetalle['MODT_Obs'],$tblDetalle['MODT_modtID']],intval($intCode));
                    }
                    break;
                  case "B":
                    $strSql="UPDATE InvMovimientoDet SET MODT_UsuaDate=$gstrFechaHoy,MODT_Estatus='B',MODT_UsuaID=? WHERE MODT_modtID=?";
                    $stmt = $db->prepare($strSql);
                    $stmt->execute([$intUsrId,$tblDetalle['MODT_modtID']]);
                    if ($bolReubicacion){
                        $strSql ="UPDATE InvMovimientoDet SET MODT_Estatus = 'B',MODT_UsuaDate=$gstrFechaHoy,MODT_UsuaID=?                        
                        WHERE MODT_Estatus='H' AND MODT_ReferID =? AND MODT_MoinID=?";
                        $stmt = $db->prepare($strSql);
                        $stmt->execute([$intUsrId,$tblDetalle['MODT_modtID'],$intCode]);
                    }                    
                    break;
                }
            }      
            //FIN Detalle
        }
        if ($bolAfectoExi) {//ACTUALIZAR LA EXISTENCIA
            sMoinAfectaExistencia($intCode, $intAlmacenId, "+");
        }
        //Si es Traspaso se ejecuta lo sig.
        if ($intAlmacenIdTraspaso>0){
            $intReferencia=$tblNombre['MOIN_Referencia'];//La Referencia es el Id del Mov del Almacen destino
            unset($tblNombre['AlmDestino']);//Quitamos el atributo Almacen Destino ya lo tenemos en intAlmacenIdTraspaso
            $tblNombre['MOIN_AlmacenCataID']=$intAlmacenIdTraspaso;//Indicamos en el XML que el Id del Almacén es el Id de Destino
            $tblNombre['MOIN_Referencia']=$intCode;//La Referencia en el Almacen de destino es el Id del almacen Origen
            $strSql = "SELECT CATA_CataID FROM paraCatalogo WHERE CATA_Tipo='ALMACENMOV' AND CATA_Desc1 LIKE 'ENT.OTRO ALMACEN'";
            $stmt = $db->prepare($strSql);$stmt->execute();
            $row= $stmt->fetch();
            if($row){
                $tblNombre['MOIN_TipoMovCataID']= $row['CATA_CataID'];
            }         
            if ($intReferencia>0){
                //Eliminamos el Detalle del xml ya que se va a insertar vía Query                        
                unset($xDoc->InvMovimiento->InvMovimientoDet);
            }else if ($intContIDTraspaso>0) {
                foreach ($xDoc->InvMovimiento->InvMovimientoDet as $tblDetalle) {
                    $tblDetalle['MODT_ContID']=$intContIDTraspaso;
                }
            }
            // Actualizamos el xml
            $strWriter=$xDoc->asXML();
            if ($intReferencia>0){//Si es mayor a 0 es un cambio para el almacén destino
                pa_MOIN_abcInvMovimiento($intReferencia, $strWriter, $intUsrId, $strIpAddress);
                //Damos de baja el detalle del movimiento en el Almacén destino
                sMoinAfectaExistencia($intReferencia, $intAlmacenIdTraspaso, "-");
                $strSql = "UPDATE InvMovimientoDet SET MODT_Estatus = 'B'
                    ,MODT_UsuaDate=$gstrFechaHoy ,MODT_UsuaID=?
                     WHERE MODT_MoinID=?
                     AND MODT_Estatus <> 'B'";
                $stmt = $db->prepare($strSql);
                $stmt->execute([$intUsrId,$intReferencia]);
                //Insertamos el detalle del movimiento en el Almacén destino
                $strSql = "INSERT INTO InvMovimientoDet (MODT_MoinID,MODT_ProdID,MODT_ContID,MODT_Cantidad,MODT_Costo,MODT_UsuaID,MODT_PvarID,MODT_UsuaDate)
                    SELECT ".$intReferencia.",MODT_ProdID,".($intContIDTraspaso > 0 ? $intContIDTraspaso: "0" ) .",SUM(MODT_Cantidad)*-1,MODT_Costo,".$intUsrId.",MODT_PvarID,$gstrFechaHoy
                    FROM InvMovimientoDet WHERE MODT_MoinID=?
                    AND MODT_Estatus <> 'B'
                    GROUP BY MODT_ProdID,MODT_PvarID,MODT_ContID,MODT_Costo";
                    $stmt = $db->prepare($strSql);
                    $stmt->execute([$intCode]);                    
                    sMoinAfectaExistencia($intReferencia, $intAlmacenIdTraspaso, "+");
            }else {//Es un Insert en el almacén destino
                $intReferencia = pa_MOIN_abcInvMovimiento($intReferencia, $strWriter, $intUsrId, $strIpAddress);
                //Actualizamos el Almacén origen con la referencia del Mov. del almacen destino
                $strSql = "UPDATE InvMovimiento SET MOIN_Referencia=? ,MOIN_UsuaDate=$gstrFechaHoy WHERE MOIN_MoinId=?";
                $stmt = $db->prepare($strSql);
                $stmt->execute([$intReferencia,$intCode]);                                                    
            }
        }
    }
    return $intCode;
}
function fInsertInvMovimiento($strMOIN_AlmacenCataID,$strMOIN_TipoMovCataID,$strMOIN_Fecha,$strMOIN_Obs,$strMOIN_Referencia,$intUsrId,$strMOIN_Estatus)
{
    global $db;
    global $gstrFechaHoy;
    $intResultado=0;
    if ($db) {
        if (intval($strMOIN_AlmacenCataID)>0 && intval($strMOIN_TipoMovCataID)>0){
            $intFolio=0;
            $intSubFolio=0;
            $strSql = "SELECT MAX(MOIN_Folio) AS Resultado FROM InvMovimiento WHERE MOIN_AlmacenCataID=:MOIN_AlmacenCataID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':MOIN_AlmacenCataID', $strMOIN_AlmacenCataID, PDO::PARAM_INT);  
            $stmt->execute();  
            $row= $stmt->fetch();
            $intFolio= intval($row['Resultado'])+1;                         
            $strSql = "SELECT MAX(MOIN_SubFolio) AS Resultado FROM InvMovimiento WHERE MOIN_AlmacenCataID=:MOIN_AlmacenCataID AND MOIN_TipoMovCataID=:MOIN_TipoMovCataID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':MOIN_AlmacenCataID', $strMOIN_AlmacenCataID, PDO::PARAM_INT);  
            $stmt->bindParam(':MOIN_TipoMovCataID', $strMOIN_TipoMovCataID, PDO::PARAM_INT);  
            $stmt->execute();   
            $row= $stmt->fetch();
            $intSubFolio= intval($row['Resultado'])+1;            
            $strSql="INSERT INTO InvMovimiento (MOIN_AlmacenCataID,MOIN_TipoMovCataID,MOIN_Folio,MOIN_SubFolio,MOIN_Fecha,MOIN_Obs,MOIN_Referencia,MOIN_UsuaID,MOIN_UsuaDate,MOIN_Estatus)
            VALUES (?,?,?,?,?,?,?,?,$gstrFechaHoy,?)";
            $stmt = $db->prepare($strSql);
            $stmt->execute([$strMOIN_AlmacenCataID,$strMOIN_TipoMovCataID,$intFolio,$intSubFolio,$strMOIN_Fecha,$strMOIN_Obs,$strMOIN_Referencia,$intUsrId,$strMOIN_Estatus]); 
            $intResultado=$db->lastInsertId();       
        }        
    }
    return $intResultado;
}
function sMoinAfectaExistencia($intCode,$intAlmacenId,$strSigno)
{    
    global $db;
    global $gstrFechaHoy;
    $intResultado=0;
    if ($db) {
        //SI EL ESTATUS ES P QUE NO AFECTE EXISTENCIAS.
        $strEstatus="";
        $strSql = "SELECT MOIN_Estatus FROM InvMovimiento WHERE MOIN_MoinId=?";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$intCode]);
        $row= $stmt->fetch();
        if($row){
            $strEstatus=$row['MOIN_Estatus'];
        }
        if ($strEstatus!="P"){
            $strSql="CREATE TEMP VIEW TempInvPxC AS
            SELECT InvProductoContenedor.PTCO_PtcoId PtcoId, InvMovimientoDet.MODT_ContID contID,InvMovimientoDet.MODT_ProdID ProdId
            ,ifnull(MIN(InvProductoContenedor.PTCO_Existencia),0)".$strSigno."SUM(InvMovimientoDet.MODT_Cantidad) Existencia,InvMovimientoDet.MODT_PvarID PvarID
            FROM  InvMovimientoDet LEFT JOIN InvProductoContenedor ON InvMovimientoDet.MODT_ProdID=InvProductoContenedor.PTCO_ProdId 
            AND InvMovimientoDet.MODT_ContID=InvProductoContenedor.PTCO_contID AND InvMovimientoDet.MODT_PvarID=InvProductoContenedor.PTCO_PvarID
            AND InvProductoContenedor.PTCO_Estatus<>'B'
            WHERE InvMovimientoDet.MODT_Cantidad<>0
            AND InvMovimientoDet.MODT_Estatus<>'B'
            AND InvMovimientoDet.MODT_MoinID=?
            GROUP BY InvProductoContenedor.PTCO_PtcoId,InvMovimientoDet.MODT_ContID,InvMovimientoDet.MODT_ProdID,InvMovimientoDet.MODT_PvarID;
            INSERT OR REPLACE INTO InvProductoContenedor(PTCO_PtcoId, PTCO_contID,PTCO_ProdId,PTCO_Existencia,PTCO_PvarID,PTCO_UsuaDate)
            SELECT PtcoId,contID,ProdId,Existencia,PvarID,$gstrFechaHoy FROM TempInvPxC;
            INSERT OR REPLACE INTO InvProductoAlmacen(PTAL_PtalID,PTAL_AlmacenCataID,PTAL_ProdId,PTAL_Existencia,PTAL_PvarID,PTAL_UsuaDate)
            SELECT InvProductoAlmacen.PTAL_PtalID,$intAlmacenId,ProdId,SUM(Existencia),PvarID,$gstrFechaHoy 
            FROM TempInvPxC LEFT JOIN InvProductoAlmacen ON InvProductoAlmacen.PTAL_ProdID=TempInvPxC.ProdId AND InvProductoAlmacen.PTAL_AlmacenCataID=$intAlmacenId
            AND InvProductoAlmacen.PTAL_PvarID=TempInvPxC.PvarID AND InvProductoAlmacen.PTAL_Estatus='A'
            GROUP BY InvProductoAlmacen.PTAL_PtalID,ProdId,PvarID;";

            $stmt = $db->prepare($strSql);
            $stmt->execute([$intCode]);                    
        }
    }
}
//InvProductoAlmacen
function pa_PTAL_abcInvProductoAlmacen($intCode, $strXml, $intUsrId, $strIpAddress)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        $xDoc= new SimpleXMLElement($strXml);
        $tblNombre=$xDoc->InvProductoAlmacen;
        $strAccion=$tblNombre['Accion'];
        switch ($strAccion) {
          case "A":
            $strSql="INSERT INTO InvProductoAlmacen (PTAL_ProdID,PTAL_AlmacenCataID,PTAL_Rm,PTAL_TipoRm,PTAL_TiempoMinimo,PTAL_TiempoMaximo,PTAL_MesesRm,PTAL_FechaRm,PTAL_Obs,PTAL_UsuaID,PTAL_UsuaDate)
            VALUES (?,?,?,?,?,?,?,?,?,?,$gstrFechaHoy)";
            $stmt = $db->prepare($strSql);
            $stmt->execute([$tblNombre['PTAL_ProdID'],$tblNombre['PTAL_AlmacenCataID'],$tblNombre['PTAL_Rm'],$tblNombre['PTAL_TipoRm'],$tblNombre['PTAL_TiempoMinimo'],$tblNombre['PTAL_TiempoMaximo'],$tblNombre['PTAL_MesesRm'],$tblNombre['PTAL_FechaRm'],$tblNombre['PTAL_Obs'],$intUsrId]);
            $intCode=$db->lastInsertId();
          break;
          case "B":
            $strSql="UPDATE InvProductoAlmacen SET PTAL_Estatus = 'B' ,PTAL_UsuaDate=$gstrFechaHoy, PTAL_UsuaID=:PTAL_UsuaID
            WHERE PTAL_PtalID=:PTAL_PtalID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':PTAL_UsuaID', intval($intUsrId), PDO::PARAM_INT);
            $stmt->bindParam(':PTAL_PtalID', intval($intCode), PDO::PARAM_INT);
            $stmt->execute();
          break;
          case "C":
            foreach ($xDoc->InvProductoAlmacen->Det as $tblDetalle) {                
                $strSql = "UPDATE InvProductoAlmacen SET 
                PTAL_TipoRm=:PTAL_TipoRm,PTAL_TiempoMinimo=:PTAL_TiempoMinimo,PTAL_TiempoMaximo=:PTAL_TiempoMaximo,PTAL_MesesRm=:PTAL_MesesRm
                ,PTAL_Obs=:PTAL_Obs,PTAL_UsuaDate=$gstrFechaHoy ,PTAL_UsuaID=:PTAL_UsuaID
                WHERE PTAL_PtalID=:PTAL_PtalID";
                $stmt = $db->prepare($strSql);
                $stmt->bindParam(':PTAL_TipoRm', $tblDetalle['PTAL_TipoRm'], PDO::PARAM_STR);
                $stmt->bindParam(':PTAL_TiempoMinimo', $tblDetalle['PTAL_TiempoMinimo'], PDO::PARAM_STR);
                $stmt->bindParam(':PTAL_TiempoMaximo', intval($tblDetalle['PTAL_TiempoMaximo']), PDO::PARAM_STR);
                $stmt->bindParam(':PTAL_MesesRm', intval($tblDetalle['PTAL_MesesRm']), PDO::PARAM_STR);
                $stmt->bindParam(':PTAL_Obs', intval($tblDetalle['PTAL_Obs']), PDO::PARAM_STR);                
                $stmt->bindParam(':PTAL_UsuaID', intval($intUsrId), PDO::PARAM_INT);
                $stmt->bindParam(':PTAL_PtalID', intval($intCode), PDO::PARAM_INT);
                $stmt->execute();                
            }                

          break;
          case "EXIPXC"://ACTUALIZA EN InvProductoContenedor
            //MANDAMOS TODO A CERO PXC
            $strSql = "UPDATE InvProductoContenedor 
            SET InvProductoContenedor.PTCO_Existencia=0,InvProductoContenedor.PTCO_UsuaDate=$gstrFechaHoy
            FROM InvProductoContenedor INNER JOIN InvContenedor ON InvProductoContenedor.PTCO_contID=InvContenedor.CONT_CONTID
            INNER JOIN InvUbicacion ON InvContenedor.CONT_ubicCataID=InvUbicacion.UBIC_UbicCataID
            WHERE InvUbicacion.UBIC_AlmaID=".$intCode." AND InvProductoContenedor.PTCO_Estatus<>'B'
            AND InvContenedor.CONT_Estatus<>'B'";            
            $stmt = $db->prepare($strSql);
            $stmt->execute();
            //ACTUALIZAMOS LOS DIFERENTES PXC
            $strSql = "UPDATE InvProductoContenedor
            SET InvProductoContenedor.PTCO_Existencia=TempExiPXC.Existencia,InvProductoContenedor.PTCO_UsuaDate= $gstrFechaHoy 
            FROM InvProductoContenedor INNER JOIN TempExiPXC ON TempExiPXC.ProdID=InvProductoContenedor.PTCO_ProdId AND TempExiPXC.ContID=InvProductoContenedor.PTCO_contID AND TempExiPXC.PvarID=InvProductoContenedor.PTCO_PvarID
            WHERE InvProductoContenedor.PTCO_Estatus<>'B'
            AND InvProductoContenedor.PTCO_Existencia<>TempExiPXC.Existencia";
            $stmt = $db->prepare($strSql);
            $stmt->execute();            
            //INSERTA LOS QUE NO EXISTEN PXC
            $strSql = "INSERT INTO InvProductoContenedor(PTCO_contID,PTCO_ProdId,PTCO_Existencia,PTCO_PvarID,PTCO_UsuaDate)
            SELECT ContID,ProdID,Existencia,PvarID,$gstrFechaHoy
            FROM TempExiPXC WHERE Existencia<>0 AND TempExiPXC.ProdID NOT IN (SELECT InvProductoContenedor.PTCO_ProdId FROM InvProductoContenedor WHERE InvProductoContenedor.PTCO_ProdId=TempExiPXC.ProdID
            AND TempExiPXC.ContID=InvProductoContenedor.PTCO_contID AND TempExiPXC.PvarID=InvProductoContenedor.PTCO_PvarID AND InvProductoContenedor.PTCO_Estatus<>'B')";           
            $stmt = $db->prepare($strSql);
            $stmt->execute();            
            //MANDAMOS TODO A CERO PXA
            $strSql = "UPDATE InvProductoAlmacen
            SET PTAL_Existencia=0,PTAL_UsuaDate=$gstrFechaHoy 
            WHERE PTAL_AlmacenCataID=". $intCode;
            $stmt = $db->prepare($strSql);
            $stmt->execute();
            $strSql = "DELETE FROM TempExiPXC";
            $stmt = $db->prepare($strSql);
            $stmt->execute();
            $strSql = "INSERT INTO TempExiPXC(PvarID,ProdID,ContID,Existencia)
            SELECT InvProductoContenedor.PTCO_PvarID,InvProductoContenedor.PTCO_ProdId,0 AS ContID,SUM(PTCO_Existencia) AS Existencia
            FROM InvProductoContenedor,InvContenedor,InvUbicacion
            WHERE InvProductoContenedor.PTCO_contID=InvContenedor.CONT_ContID
            AND InvContenedor.CONT_UbicCataID=InvUbicacion.UBIC_UbicCataID
            AND InvUbicacion.UBIC_AlmaID=". $intCode .
            " AND InvProductoContenedor.PTCO_Estatus<>'B' AND InvContenedor.CONT_Estatus<>'B'
            GROUP BY InvProductoContenedor.PTCO_ProdId,InvProductoContenedor.PTCO_PvarID";
            $stmt = $db->prepare($strSql);
            $stmt->execute();  
            //ACTUALIZAMOS LOS DIFERENTES PXA
            $strSql = "UPDATE InvProductoAlmacen
            SET InvProductoAlmacen.PTAL_Existencia=TempExiPXC.Existencia,InvProductoAlmacen.PTAL_UsuaDate=$gstrFechaHoy
            FROM InvProductoAlmacen INNER JOIN TempExiPXC ON TempExiPXC.ProdID=InvProductoAlmacen.PTAL_ProdId AND TempExiPXC.PvarID=InvProductoAlmacen.PTAL_PvarID
            WHERE InvProductoAlmacen.PTAL_Estatus<>'B'
            AND InvProductoAlmacen.PTAL_Existencia<>TempExiPXC.Existencia
            AND InvProductoAlmacen.PTAL_AlmacenCataID=".$intCode;
            $stmt = $db->prepare($strSql);
            $stmt->execute();   
            //INSERTA LOS QUE NO EXISTEN PXA            
            $strSql = "INSERT INTO InvProductoAlmacen(PTAL_AlmacenCataID,PTAL_ProdId,PTAL_Existencia,PTAL_PvarID,PTAL_UsuaDate)
            SELECT ". $intCode." AS AlmaID,TempExiPXC.ProdID,TempExiPXC.Existencia,TempExiPXC.PvarID,$gstrFechaHoy
            FROM TempExiPXC WHERE TempExiPXC.ProdID NOT IN (SELECT InvProductoAlmacen.PTAL_ProdId FROM InvProductoAlmacen 
            WHERE InvProductoAlmacen.PTAL_ProdId=TempExiPXC.ProdID AND TempExiPXC.PvarID=InvProductoAlmacen.PTAL_PvarID 
            AND InvProductoAlmacen.PTAL_Estatus<>'B' AND PTAL_AlmacenCataID=". $intCode.")";
            $stmt = $db->prepare($strSql);
            $stmt->execute();                           
          break;
          case "DEMACTIVA":
            //MANDAMOS TODO A CERO
            $strSql = "UPDATE InvProductoAlmacen
            SET PTAL_Demanda=0, PTAL_UsuaDate=$gstrFechaHoy
            WHERE PTAL_Estatus<>'B' AND PTAL_AlmacenCataID=".$intCode;
            $stmt = $db->prepare($strSql);
            $stmt->execute(); 
            $strSql = "DELETE FROM TempExiPXC";
            $stmt = $db->prepare($strSql);
            $stmt->execute();   
            $strSql = "INSERT INTO TempExiPXC(ProdID,PvarID,Existencia)
            SELECT DEPE_ProdID,PVAR_PvarID, SUM(DEPE_Pedido-DEPE_Surtido) Demanda
            FROM VtaPedido INNER JOIN VtaPedidoDet on PEDI_PediID=VtaPedidoDet.DEPE_PediID AND DEPE_Estatus<>'B' AND PEDI_AlmacenID=".$intCode
            ." AND PEDI_Estatus <>'B' AND PEDI_Numero >0 AND DEPE_Pedido>DEPE_Surtido AND (DEPE_FactID IS NULL OR DEPE_FactID=0)
            INNER JOIN IngProducto ON DEPE_ProdID=PROD_ProdID
            INNER JOIN paraCatalogo ON PEDI_Estatus=CATA_Desc1 AND CATA_Code1=1
            LEFT JOIN IngProductoVariable ON DEPE_PvarID=PVAR_PvarID AND PVAR_Estatus='A'
            AND DEPE_Pedido>DEPE_Surtido
            GROUP BY DEPE_ProdID,PVAR_PvarID ORDER BY DEPE_ProdID";
            $stmt = $db->prepare($strSql);
            $stmt->execute();   
            //ACTUALIZA LA DEMANDA ACTIVA
            $strSql = "UPDATE InvProductoAlmacen
            SET InvProductoAlmacen.PTAL_Demanda=TempExiPXC.Existencia,InvProductoAlmacen.PTAL_UsuaDate=$gstrFechaHoy 
            FROM InvProductoAlmacen INNER JOIN TempExiPXC ON TempExiPXC.ProdID=InvProductoAlmacen.PTAL_ProdId AND TempExiPXC.PvarID=InvProductoAlmacen.PTAL_PvarID
            WHERE InvProductoAlmacen.PTAL_Estatus<>'B'
            AND InvProductoAlmacen.PTAL_Demanda<>TempExiPXC.Existencia
            AND InvProductoAlmacen.PTAL_AlmacenCataID=".$intCode;
            $stmt = $db->prepare($strSql);
            $stmt->execute();  
            //INSERTA LOS QUE NO EXISTEN PXA
            $strSql = "INSERT INTO InvProductoAlmacen(PTAL_AlmacenCataID,PTAL_ProdId,PTAL_Demanda,PTAL_PvarID,PTAL_UsuaDate)
            SELECT ".$intCode." AS AlmaID,TempExiPXC.ProdID,TempExiPXC.Existencia,TempExiPXC.PvarID,$gstrFechaHoy
            FROM TempExiPXC WHERE TempExiPXC.ProdID NOT IN (SELECT InvProductoAlmacen.PTAL_ProdId FROM InvProductoAlmacen 
            WHERE InvProductoAlmacen.PTAL_ProdId=TempExiPXC.ProdID AND TempExiPXC.PvarID=InvProductoAlmacen.PTAL_PvarID AND InvProductoAlmacen.PTAL_Estatus<>'B' AND PTAL_AlmacenCataID=".$intCode.")";
            $stmt = $db->prepare($strSql);
            $stmt->execute();            
          break;

        }        
    }
    return $intCode;    
}
//InvContenedor
function pa_CONT_abcInvContenedor($intCode, $strXml, $intUsrId, $strIpAddress)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        $xDoc= new SimpleXMLElement($strXml);
        $tblNombre=$xDoc->InvContenedor;
        $strAccion=$tblNombre['Accion'];
        switch ($strAccion) {
          case "A":
            $strSql = "SELECT CONT_CONTID AS Resultado FROM InvContenedor WHERE CONT_Estatus='A' AND CONT_clave=:CONT_clave AND CONT_ubicCataID=:CONT_ubicCataID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':CONT_clave', $tblNombre['CONT_clave'], PDO::PARAM_STR);
            $stmt->bindParam(':CONT_ubicCataID', intval($tblNombre['CONT_ubicCataID']), PDO::PARAM_INT);            
            $stmt->execute();
            $row= $stmt->fetch();
            if($row){
                $intCode=intval($row['Resultado']);
            }            
            if($intCode==0){
                $strSql="INSERT INTO InvContenedor (CONT_clave,CONT_ubicCataID,CONT_peso,CONT_L1,CONT_L2,CONT_L3,CONT_L4,CONT_L5,CONT_UsuaDate)
                VALUES (?,?,?,?,?,?,?,?,$gstrFechaHoy)";
                $stmt = $db->prepare($strSql);
                $stmt->execute([$tblNombre['CONT_clave'],$tblNombre['CONT_ubicCataID'],$tblNombre['CONT_peso'],$tblNombre['CONT_L1'],$tblNombre['CONT_L2'],$tblNombre['CONT_L3'],$tblNombre['CONT_L4'],$tblNombre['CONT_L5']]);
                $intCode=$db->lastInsertId();
            }
          break;
          case "B":
            $strSql="UPDATE InvContenedor SET CONT_Estatus = 'B' ,CONT_UsuaDate=$gstrFechaHoy WHERE CONT_contID=?";
            $stmt = $db->prepare($strSql);
            $stmt->execute([$intCode]);
          break;
          case "C":
            $strSql="UPDATE InvContenedor SET CONT_UsuaDate=$gstrFechaHoy ,CONT_Clave=:CONT_Clave,CONT_ubicCataID=:CONT_ubicCataID,CONT_peso=:CONT_peso,CONT_L1=:CONT_L1,CONT_L2=:CONT_L2,CONT_L3=:CONT_L3
            ,CONT_L4=:CONT_L4 ,CONT_L5=:CONT_L5 WHERE CONT_contID=:CONT_contID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':CONT_Clave', $tblNombre['CONT_Clave'], PDO::PARAM_STR);
            $stmt->bindParam(':CONT_ubicCataID', intval($tblNombre['CONT_ubicCataID']), PDO::PARAM_INT);
            $stmt->bindParam(':CONT_peso', $tblNombre['CONT_peso'], PDO::PARAM_STR);
            $stmt->bindParam(':CONT_L1', $tblNombre['CONT_L1'], PDO::PARAM_STR);
            $stmt->bindParam(':CONT_L2', $tblNombre['CONT_L2'], PDO::PARAM_STR);
            $stmt->bindParam(':CONT_L3', $tblNombre['CONT_L3'], PDO::PARAM_STR);
            $stmt->bindParam(':CONT_L4', $tblNombre['CONT_L4'], PDO::PARAM_STR);
            $stmt->bindParam(':CONT_L5', $tblNombre['CONT_L5'], PDO::PARAM_STR);
            $stmt->bindParam(':CONT_contID', intval($intCode), PDO::PARAM_INT);
            $stmt->execute();
          break;
        }        
    }
    return $intCode;
}
function pa_CONT_ConsultaInvContenedor($Accion, $Code1, $Parametro1, $Parametro2)
{
    global $db;
    if ($db) {
        switch ($Accion) {
        case "VALCONTENEDOR":
            $strSql = "SELECT CONT_ContID,CONT_ubicCataID,UBIC_Clave
            FROM InvContenedor INNER JOIN InvUbicacion ON CONT_ubicCataID=UBIC_UbicCataID
            WHERE CONT_Estatus<>'B' AND UBIC_Estatus<>'B'
            AND CONT_Clave=:Parametro1 AND UBIC_AlmaID=:Code1";
            if ($Parametro2<>''){
                $strSql .= " AND UBIC_Clave=:Parametro2";
            }
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':Parametro1', $Parametro1, PDO::PARAM_STR);            
            $stmt->bindParam(':Code1', intval($Code1), PDO::PARAM_INT);
            if ($Parametro2<>''){
                $stmt->bindParam(':Parametro2', $Parametro2, PDO::PARAM_STR);            
            }
            $stmt->execute();
            return $stmt;            
        break;
        }

    } else {
        return null;
    }
}
//InvUbicacion
function pa_UBIC_abcInvUbicacion($intCode, $strXml, $intUsrId, $strIpAddress)
{
    global $db;
    global $gstrFechaHoy;
    if ($db) {
        $xDoc= new SimpleXMLElement($strXml);
        $tblNombre=$xDoc->InvUbicacion;
        $strAccion=$tblNombre['Accion'];
        switch ($strAccion) {
          case "A":
            $strSql = "SELECT UBIC_UbicCataID AS Resultado FROM InvUbicacion WHERE UBIC_Estatus='A' AND UBIC_Clave=:UBIC_Clave AND UBIC_AlmaID=:UBIC_AlmaID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':UBIC_Clave', $tblNombre['UBIC_Clave'], PDO::PARAM_STR);
            $stmt->bindParam(':UBIC_AlmaID', intval($tblNombre['UBIC_AlmaID']), PDO::PARAM_INT);            
            $stmt->execute();
            $row= $stmt->fetch();
            if($row){
                $intCode=intval($row['Resultado']);
            }            
            if($intCode==0){
                $strSql="INSERT INTO InvUbicacion (UBIC_Clave,UBIC_AlmaID,UBIC_L1,UBIC_L2,UBIC_L3,UBIC_L4,UBIC_UsuaDate)
                VALUES (?,?,?,?,?,?,$gstrFechaHoy)";
                $stmt = $db->prepare($strSql);
                $stmt->execute([$tblNombre['UBIC_Clave'],$tblNombre['UBIC_AlmaID'],$tblNombre['UBIC_L1'],$tblNombre['UBIC_L2'],$tblNombre['UBIC_L3'],$tblNombre['UBIC_L4']]);
                $intCode=$db->lastInsertId();
            }
          break;
          case "B":
            $strSql="UPDATE InvUbicacion SET UBIC_Estatus = 'B' ,UBIC_UsuaDate=$gstrFechaHoy WHERE UBIC_UbicCataID=?";
            $stmt = $db->prepare($strSql);
            $stmt->execute([$intCode]);
          break;
          case "C":
            $strSql="UPDATE InvUbicacion SET UBIC_UsuaDate=$gstrFechaHoy ,UBIC_Clave=:UBIC_Clave,UBIC_AlmaID=:UBIC_AlmaID,UBIC_L1=:UBIC_L1,UBIC_L2=:UBIC_L2,UBIC_L3=:UBIC_L3,UBIC_L4=:UBIC_L4
            WHERE UBIC_UbicCataID=:UBIC_UbicCataID";
            $stmt = $db->prepare($strSql);
            $stmt->bindParam(':UBIC_Clave', $tblNombre['UBIC_Clave'], PDO::PARAM_STR);
            $stmt->bindParam(':UBIC_AlmaID', intval($tblNombre['UBIC_AlmaID']), PDO::PARAM_INT);
            $stmt->bindParam(':UBIC_L1', $tblNombre['UBIC_L1'], PDO::PARAM_STR);
            $stmt->bindParam(':UBIC_L2', $tblNombre['UBIC_L2'], PDO::PARAM_STR);
            $stmt->bindParam(':UBIC_L3', $tblNombre['UBIC_L3'], PDO::PARAM_STR);
            $stmt->bindParam(':UBIC_L4', $tblNombre['UBIC_L4'], PDO::PARAM_STR);
            $stmt->bindParam(':UBIC_UbicCataID', intval($intCode), PDO::PARAM_INT);
            $stmt->execute();
          break;
        }        
    }
    return $intCode;
}
function pa_UBIC_ConsultaInvUbicacion($Accion, $Code1, $Parametro1, $Parametro2)
{
    global $db;
    if ($db) {
        switch ($Accion) {
        case "DEFAULT":
            $strSql = "SELECT MIN(UBIC_UbicCataID) UBIC_UbicCataID
            FROM InvUbicacion WHERE UBIC_Estatus<>'B' AND UBIC_AlmaID=:Code1";
            $stmt = $db->prepare($strSql);            
            $stmt->bindParam(':Code1', intval($Code1), PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;            
        break;
        }

    } else {
        return null;
    }
}