<?php

class DBphp extends SQLite3

{

  function __construct()

  {

    $this->open('patris.db');

  }

}

$db = new DBphp();

$query1="INSERT INTO Product".

"(p_name,price,quantity)".

"VALUES ('pencil',10,50);";

$query2="INSERT INTO Product".

"(p_name,price,quantity)".

"VALUES ('Eraser',5,60);";

$db->exec($query1);

$db->exec($query2);

$db->close();
?>
