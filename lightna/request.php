<?php
namespace Lightna;
class Request{
    private $request_url;
    private $port;
    private $host;
    private $protocol;
    private $uri;
    private $method;
    //Code for getting the full URL was found here: http://stackoverflow.com/a/8891890
    private function parseURL(){
        $server = $_SERVER;
        $this->method = isset($server['REQUEST_METHOD']) ? $server['REQUEST_METHOD'] : "";
        $ssl = ( ! empty( $server['HTTPS'] ) && $server['HTTPS'] == 'on' );
        $sp = isset($server['SERVER_PROTOCOL']) ? strtolower($server['SERVER_PROTOCOL']) : "";
        $this->protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
        $this->port = isset($server['SERVER_PORT']) ? $server['SERVER_PORT'] : "";
        // /$this->port = ( ( ! $ssl && $this->port=='80' ) || ( $ssl && $this->port=='443' ) ) ? '' : ':'.$this->port;
        $host = isset($server['HTTP_HOST']) ? $server['HTTP_HOST'] : "";
        $this->host = isset( $host ) ? $host : isset($server['SERVER_NAME']) ? 
            $server['SERVER_NAME'] . ":".$this->port : "";
        $this->uri = isset($server['REQUEST_URI']) ? $server['REQUEST_URI'] : "";
        $this->request_url = $this->protocol . '://' . $this->host . $this->uri;
    }
    function __construct(){
        $this->parseURL();
    }

    public function getURL(){
        return $this->request_url;
    }

    public function getPort(){
        return $this->port;
    }

    public function getHost(){
        return $this->host;
    }

    public function getUri(){
        return $this->uri;
    }

    public function getMethod(){
        return $this->method;
    }
}
?>