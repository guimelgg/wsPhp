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
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
 ?>
