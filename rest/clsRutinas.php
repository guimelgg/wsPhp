<?php
function CrearHash($strSource){
  $utfString = mb_convert_encoding($strSource,"UTF-16LE");
  $hashTag = sha1($utfString,true);
  $base64Tag = base64_encode($hashTag);
  return $base64Tag;
}

 ?>
