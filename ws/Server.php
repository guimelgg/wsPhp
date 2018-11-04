<?php
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);

class Server
{
    private $_soapServer = null;
    public function __construct()
    {
        require_once(getcwd() . '/lib/nusoap.php');
        require_once(getcwd() . '/Service.php');
        $this->_soapServer = new soap_server();
        $this->_soapServer->configureWSDL("Server","urn:Server");
        //$namespace = "http://localhost:9090/wsPpal/Server.php";
        $this->_soapServer->register(
           'Service.getUsers', // method name
           array(), // input parameters
           array('return' => 'xsd:Array'), // output parameters
           false, // namespace
           false, // soapaction
           'rpc', // style
           'encoded', // use
           'Servicio que retorna un array de usuarios' // documentation
        );

        $this->_soapServer->register(
            'Service.sum',
            array('a' => 'xsd:string', 'b' => 'xsd:string'),
            array('return' => 'xsd:int'),
            false,
            false,
            "rpc",
            "encoded",
            "Servicio que suma dos números"
        );

        $this->_soapServer->register(
            "Service.getName",
            array('name' => "xsd:string"),
            array("return" => "xsd:string"),
            false,
            false,
            "rpc",
            "encoded",
            "Servicio que retorna un string"
        );

        //procesamos el webservice
        $this->_soapServer->service(file_get_contents("php://input"));
        //$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
        //$this->_soapServer->service($POST_DATA);
    }
}
$server = new Server();


?>
