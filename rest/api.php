<?php
header("Content-Type:application/json");
if (!ob_start("ob_gzhandler")) {
    ob_start();
}
try {
  //  
    $gWsConfig="www.pymeti.com/rest/api.php,wswcf.azurewebsites.net/rest/api.php,REST";
      //localhost/wsPhp/rest/api.php,wswcf.azurewebsites.net/rest/api.php,REST
      //wswcf.azurewebsites.net,www.pymeti.com/rest/api.php,WCF
      //wswcf.azurewebsites.net/rest/api.php,www.pymeti.com/rest/api.php,REST
      //www.pymeti.com/rest/api.php,wswcf.azurewebsites.net/rest/api.php,REST

    $strOpcion=filter_input(INPUT_GET, 'strOpcion');
    if (!$strOpcion) {
        $strOpcion=filter_input(INPUT_POST, 'strOpcion');
    }
    //$Accion
    $Accion = filter_input(INPUT_GET, 'Accion');
    if (!$Accion) {
        $Accion = filter_input(INPUT_POST, 'Accion');
    }
    //$Code1
    $Code1 = filter_input(INPUT_GET, 'Code1');
    if (!$Code1) {
        $Code1 = filter_input(INPUT_POST, 'Code1');
    }
    //$Parametro1
    $Parametro1 = filter_input(INPUT_GET, 'Parametro1');
    if (!$Parametro1) {
        $Parametro1 = filter_input(INPUT_POST, 'Parametro1');
    }
    
    //$Parametro2
    $Parametro2 = filter_input(INPUT_GET, 'Parametro2');
    if (!$Parametro2) {
        $Parametro2 = filter_input(INPUT_POST, 'Parametro2');
    }


    $strResultado="";
    
    switch ($strOpcion) {//SIN BASE DE DATOS
    case "GetWsConfig":
      
      $strResultado=$gWsConfig;

    break;
    case "GetEsquemaInicial":
      $strBase=filter_input(INPUT_GET, 'strBase');
      if (!$strBase) {
          $strBase=filter_input(INPUT_POST, 'strBase');
      }
      if ($strBase!="") {
          $strBase="otros/".$strBase."bdScript.sql";
          $myfile= fopen($strBase, "r") or die("");
          $strResultado=fread($myfile, filesize($strBase));
          fclose($myfile);
      }
    break;
    case "sha1":
      include('clsRutinas.php');
      echo CrearHash($Accion);
    break;
    case "zipfileCrea"://Crea archivo zip en una ruta Temp
      $strDBName = filter_input(INPUT_GET, 'strDBName');
      if (!$strDBName) {
        $strDBName = filter_input(INPUT_POST, 'strDBName');
      }
      include('clsRutinas.php');
      echo GzipFile($strDBName);
    break;
    case "zipfileElimina"://Elimina archivo
      unlink($Accion);
    break;
    case "RespBDRemota"://En sitio alterno respaldar las bd del sitio remoto
      //Obtener el listado de todos los archivos
      include('clsRutinas.php');      
      $strValores = explode(",",$gWsConfig); 
      //echo $strValores[0];
      $strResultado= CallAPI("POST",$strValores[0],array("strOpcion" => "RespGetListaBd"));
      $strFilesToBack=explode(",",$strResultado);
      foreach ($strFilesToBack as $strFileToBack ) {
        $strResultado = CallAPI("POST",$strValores[0],array("strOpcion" => "zipfileCrea","strDBName" => $strFileToBack));
        if ($strResultado !== ""){        
          $strDownlaodLink="http://".str_replace("api.php",$strResultado,$strValores[0]);
          //echo $strDownlaodLink;
          $strFileToBackLocal="../../dbrespaldo/".str_replace(".db",".zip".date("w"),$strFileToBack);
          //echo $strFileToBack;
          file_put_contents($strFileToBackLocal,fopen($strDownlaodLink,"r"));
          //Elimina Archivo zip remoto
          //echo $strFileToBack;
          CallAPI("POST",$strValores[0],array("strOpcion" => "zipfileElimina","Accion" => $strResultado));
        }        
      }
      $strResultado='';                             
    break;
    case "RespGetListaBd"://Obtener el listado de todos los archivos a respaldar
      $strPath = "../../database/";
      $strResultado="";
      foreach(glob($strPath.'/*.db') as $file){
        $strResultado.=($strResultado==""?"":",").str_replace($strPath."/","",$file);
      }      
    break;
    case "RespPpaltoSec"://Mandar llamar el Respaldar BD del principal al secundario
      include('clsRutinas.php');      
      CallAPI("POST","wswcf.azurewebsites.net/rest/api.php",array("strOpcion" => "RespBDRemota"));
    break;
    default://CON BASE DE DATOS
      include('apidb.php');
    break;
  }
    echo $strResultado;
} catch (PDOException $e) {
    echo 'Exception : '.$e->getMessage();
}
