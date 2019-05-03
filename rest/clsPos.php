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
            break;
        }
            if ($strAccion=="C" || $strAccion=="A" && $intCode > 0) {
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
            WHERE LPRE_LpreID:=LPRE_LpreID";
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
        if ($strAccion="C" || $strAccion="A") {
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
            WHERE LPRE_LpreID:=LPRE_LpreID";
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
        if ($strAccion="C" || $strAccion="A") {
            //INICIO Detalle
            foreach ($xDoc->VtaListaDePrecio->VtaPrecio as $tblDetalle) {
                sVtaPrecioABC($tblDetalle['Accion'], $intCode, $tblDetalle['PREC_ProdID'], $tblDetalle['PREC_Precio'], $tblDetalle['PREC_PrecID'], $intUsrId, $tblDetalle['PREC_Descuento']);
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
        $strSql="SELECT MAX(INFI_Folio) AS Resultado FROM InvFisico WHERE INFI_AlmaId:=INFI_AlmaId";
        $stmt = $db->prepare($strSql);
        $stmt->bindParam(':INFI_AlmaId', $strINFI_AlmaId, PDO::PARAM_STR);  
        $stmt->execute();   
        while ($row=$stmt->fetchArray()) {
            $intFolio=intval($row['Resultado'])+1;
        }   
        $strSql="INSERT INTO InvFisico (INFI_AlmaId,INFI_Folio,INFI_Fecha,INFI_Obs,INFI_UsuaID,INFI_UsuaDate)
        VALUES (?,?,?,?,?,$gstrFechaHoy)";
        $stmt = $db->prepare($strSql);
        $stmt->execute([$strINFI_AlmaId,$intFolio,$strINFI_Fecha,$strINFI_Obs,$intUsrId]); 
        $intResultado=$db->lastInsertId();       
    }
    return $intResultado;
}