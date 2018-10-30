<?php
require_once("lib/nusoap.php");
$namespace = "http://localhost:9090/wsPpal/test3.php";
// create a new soap server
$server = new soap_server();
// configure our WSDL
$server->configureWSDL("SimpleService");
// set our namespace
$server->wsdl->schemaTargetNamespace = $namespace;
// register our WebMethod
$server->register(
                // method name:
                'ProcessSimpleType',
                // parameter list:
                array('name'=>'xsd:string'),
                // return value(s):
                array('return'=>'xsd:string'),
                // namespace:
                $namespace,
                // soapaction: (use default)
                false,
                // style: rpc or document
                'rpc',
                // use: encoded or literal
                'encoded',
                // description: documentation for the method
                'A simple Hello World web method');

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
/*$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA'])
                ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';*/

// pass our posted data (or nothing) to the soap service
//$server->service($POST_DATA);
$server->service(file_get_contents("php://input"));
exit();
?>
