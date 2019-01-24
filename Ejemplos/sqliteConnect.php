<?php

class DBphp extends SQLite3

{

function __construct()

{

$this->open('patris.db');

}

}

$db = new DBphp();

if(!$db){

echo "Oops!!! Something went wrong!!!";

} else {

echo "Database Opened!!!";

}

?>
