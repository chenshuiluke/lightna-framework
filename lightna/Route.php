<?php
namespace Lightna;
class Route{
    private $method;
    private $uri;
    private $callback;

    function __construct($method, $uri, $callback){
        $this->method = $method;
        $this->uri = $uri;
        $this->callback = $callback;
    }

    function getURI(){
        return $this->uri;
    }

    function getCallback(){
        return $this->callback;
    }

    function getMethod(){
        return $this->method;
    }
}
?>