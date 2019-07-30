<?php
function CrearHash($strSource){
  $utfString = mb_convert_encoding($strSource,"UTF-16LE");
  $hashTag = sha1($utfString,true);
  $base64Tag = base64_encode($hashTag);
  return $base64Tag;
}
function ZipFile($strDBName){
  $strArchivo = explode(".",$strDBName);
  $zip = new ZipArchive;  
  $archivoZip='temp/'.$strArchivo[0].'.zip';
  $zip->open($archivoZip,ZipArchive::CREATE);
  $strPath = "../../database/".$strDBName;
  $zip->addFile($strPath,$strDBName);
  $zip->close();
  return $archivoZip;
}
function GzipFile($strDBName){
  $strArchivo = explode(".",$strDBName);
  $strPath = "../../database/".$strDBName;
  $data = implode("", file($strPath));
  $gzdata = gzencode($data,9);
  $archivoZip='temp/'.$strArchivo[0].'.zip';
  $fp = fopen($archivoZip,"w");
  fwrite($fp,$gzdata);
  fclose($fp);
  return $archivoZip;
}
 ?>
