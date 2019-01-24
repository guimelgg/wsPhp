<?php

class DBphp extends SQLite3

{

  function __construct()

  {

    $this->open('patris.db');

  }

}

$db = new DBphp();

$query="UPDATE Product SET quantity=quantity + (quantity * 0.2)";

$db->exec($query);

$query1="SELECT * FROM Product";

$result=$db->query($query1);

echo "p_id\tp_name\tprice\tquantity\n";

while($row= $result->fetchArray()){

echo $row['p_id'] . "\t".

$row['p_name'] . "\t".

$row['price']. "\t".

$row['quantity']."\n";

}

$db->close();
?>
