<?php

class DBphp extends SQLite3

{

  function __construct()

  {

    $this->open('patris.db');

  }

}

$db = new DBphp();

$res=$db->exec("CREATE TABLE Product (p_id INTEGER PRIMARY KEY
  AUTOINCREMENT,p_name TEXT NOT NULL,price REAL,quantity
  INTEGER);");

  if($res)
  echo "Table created!!!\n";
  else
  echo "Oops!!! Something went wrong!!!";


$db->close();

?>
