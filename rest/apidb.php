<?php
$strDBName = filter_input(INPUT_GET, 'strDBName');
if (!$strDBName) {
    $strDBName = filter_input(INPUT_POST, 'strDBName');
}
//$intCode
$intCode = filter_input(INPUT_GET, 'intCode');
if (!$intCode) {
    $intCode = filter_input(INPUT_POST, 'intCode');
}
//$strXml
$strXml = filter_input(INPUT_GET, 'strXml');
if (!$strXml) {
    $strXml = filter_input(INPUT_POST, 'strXml');
}
//$intUsrId
$intUsrId = filter_input(INPUT_GET, 'intUsrId');
if (!$intUsrId) {
    $intUsrId = filter_input(INPUT_POST, 'intUsrId');
}
//$strIpAddress
$strIpAddress = filter_input(INPUT_GET, 'strIpAddress');
if (!$strIpAddress) {
    $strIpAddress = filter_input(INPUT_POST, 'strIpAddress');
}
include('db.php');
connectDB($strDBName);
//echo ($db ? "db SI" : "db NO");
if ($db) {
    $gstrFechaHoy="strftime('%Y/%m/%d %H:%M:%S',datetime('now','localtime'))";
    include('clsEnt.php');
    include('clsPos.php');
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
        $result = pa_USUA_consultaparaUsuario($Accion, $Code1, $Parametro1, $Parametro2);
        $strResultado=json_encode($result->fetchAll(PDO::FETCH_OBJ));
    break;
    case "pa_USUA_abcparaUsuario":
        $result= new \stdClass();
        $result->Resultado = pa_USUA_abcparaUsuario($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;
    case "pa_MODU_abcparaModulo":
        $result= new \stdClass();
        $result->Resultado = pa_MODU_abcparaModulo($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;
    case "pa_CATA_abcparaCatalogo":
        $result= new \stdClass();
        $result->Resultado = pa_CATA_abcparaCatalogo($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;
    case "GetEsquema":
        $strSql="SELECT BDES_Script FROM paraBdEsquema WHERE BDES_Fecha>".$Parametro1;
        $result = $db->query($strSql);
        $strResultado=json_encode($result->fetchAll(PDO::FETCH_OBJ));
    break;
    case "pa_BDSI_consultaparaBdSincroniza":
        $strResultado = pa_BDSI_consultaparaBdSincroniza($Accion, $Code1, $Parametro1, $Parametro2);
    break;
    case "pa_PROD_abcIngProducto":
        $result= new \stdClass();
        $result->Resultado = pa_PROD_abcIngProducto($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;
    case "pa_LPRE_abcVtaListaDePrecio":
        $result= new \stdClass();
        $result->Resultado = pa_LPRE_abcVtaListaDePrecio($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;
    case "pa_INFI_abcInvFisico":
        $result= new \stdClass();
        $result->Resultado = pa_INFI_abcInvFisico($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;    
    case "pa_MOIN_abcInvMovimiento":
        $result= new \stdClass();
        $result->Resultado = pa_MOIN_abcInvMovimiento($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;   
    case "pa_PTAL_abcInvProductoAlmacen":
        $result= new \stdClass();
        $result->Resultado = pa_PTAL_abcInvProductoAlmacen($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;  
    case "pa_UBIC_abcInvUbicacion":
        $result= new \stdClass();
        $result->Resultado = pa_UBIC_abcInvUbicacion($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;      
    case "pa_CAJA_abcVtaCaja":
        $result= new \stdClass();
        $result->Resultado = pa_CAJA_abcVtaCaja($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;      
    case "pa_PEDI_abcVtaPedido":
        $result= new \stdClass();
        $result->Resultado = pa_PEDI_abcVtaPedido($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;      
    case "pa_PROV_abcComProveedor":
        $result= new \stdClass();
        $result->Resultado = pa_PROV_abcComProveedor($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;      
    case "pa_ODCP_abcComOrdenCompra":
        $result= new \stdClass();
        $result->Resultado = pa_ODCP_abcComOrdenCompra($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;      
    case "pa_MOCC_abcCxpMovimiento":
        $result= new \stdClass();
        $result->Resultado = pa_MOCC_abcCxpMovimiento($intCode, $strXml, $intUsrId, $strIpAddress);
        $strResultado=json_encode($result);
    break;      
    case "pa_Direccion":
        $result= new \stdClass();
        $result->Resultado = pa_Direccion($strTipo, $intCode, $strXml, $intUsrId);
        $strResultado=json_encode($result);
    break;                              
    default:
        $xDoc= new SimpleXMLElement($strXml);
        $strSql="SELECT * FROM paraCatalogo WHERE CATA_CataID=102 ORDER BY CATA_CataID";        
        $result = $db->query($strSql);
        $strResultado=json_encode($result->fetchAll(PDO::FETCH_OBJ));
    break;
  }
    $db = null;
}
