<?php
require_once ("lib/nusoap.php");

function getProd($category) {
  if ($category == "books") {
    return join(",", array(
      "The WordPress Anthology",
      "PHP Master: Write Cutting Edge Code",
      "Buid Your Own Website the Right Way"));
  } else {
    return "No products listed under that category";
  }
}

$server = new soap_server();
$server->register("getProd");
$server->service($HPPT_RAW_POST_DATA);

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
 ?>
