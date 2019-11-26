<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demo extends MY_Controller {

    function __construct() {
        parent::__construct();

    }

    function index() {

 	$this->page_construct('demo/index', $this->data, $meta);
    }

}