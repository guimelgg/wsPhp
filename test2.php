<?php
	/* Add nusoap library */
	include_once('lib/nusoap.php');

	$namespace = "http://localhost:9090/wsPpal/test2.php";

	/* Create your functions  */
	function myFirstRequest($msg){
		return $msg;
	}

	function multiParmFunction($value1, $value2){
		/* Add your functionality here what ever you want */
		return $value1+$value2;
	}

	/* Configure your soap server */
	$server = new soap_server();
	$server->configureWSDL("index", "urn:index");
  // set our namespace
  $server->wsdl->schemaTargetNamespace = $namespace;
	/* Register your function */
	$server->register("myFirstRequest",
						array('msg' => 'xsd:string'),
						array('return' => 'xsd:string'),
						$namespace,
						false,
						"rpc",
						"encoded",
						"Some Description"
					);

	$server->register("multiParmFunction",
						array('value1' => 'xsd:string', 'value2' => 'xsd:string'),
						array('return' => 'xsd:string'),
						$namespace,
						false,
						"rpc",
						"encoded",
						"Some Description"
					);

	$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

	@$server->service($POST_DATA);
?>
