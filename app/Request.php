<?php

class Request
{
    public $url;

    function __construct()
    {
        $this->url = $_SERVER["REQUEST_URI"]; 
        var_dump($_SERVER["REQUEST_URI"]);  
    }
}

$url = new Request;
//$url->url = 'http://localhost/algen/test.php';
