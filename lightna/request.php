<?php
namespace Lightna;
class Request{
    private static $request_url;
    private static $port;
    private static $host;
    private static $protocol;
    private static $uri;
    private static $method;
    //Code for getting the full URL was found here: http://stackoverflow.com/a/8891890
    private static function parseURL(){
        //A bunch of issets in case the script is being run from the commandline via php -f
        $server = $_SERVER;
        self::$method = isset($server['REQUEST_METHOD']) ? $server['REQUEST_METHOD'] : "";
        $ssl = ( ! empty( $server['HTTPS'] ) && $server['HTTPS'] == 'on' );
        $sp = isset($server['SERVER_PROTOCOL']) ? strtolower($server['SERVER_PROTOCOL']) : "";
        self::$protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
        self::$port = isset($server['SERVER_PORT']) ? $server['SERVER_PORT'] : "";
        // /self::$port = ( ( ! $ssl && self::$port=='80' ) || ( $ssl && self::$port=='443' ) ) ? '' : ':'.self::$port;
        $host = isset($server['HTTP_HOST']) ? $server['HTTP_HOST'] : "";
        self::$host = isset( $host ) ? $host : isset($server['SERVER_NAME']) ? 
            $server['SERVER_NAME'] . ":".self::$port : "";
        self::$uri = isset($server['REQUEST_URI']) ? $server['REQUEST_URI'] : "";
        self::$request_url = self::$protocol . '://' . self::$host . self::$uri;
    }

    // function __construct(){
    //     $this->parseURL();
    // }

    public static function onLoad(){
        self::parseURL();
    }

    public static function getURL(){
        return self::$request_url;
    }

    public static function getPort(){
        return self::$port;
    }

    public static function getHost(){
        return self::$host;
    }

    public static function getUri(){
        return self::$uri;
    }

    public static function getMethod(){
        return self::$method;
    }

    public static function printContents(){
        echo nl2br("URL: " . self::getURL() . "\n");
        echo nl2br("Port: " . self::getPort() . "\n");
        echo nl2br("Host: " . self::getHost() . "\n");
        echo nl2br("Uri: " . self::getUri() . "\n");
        echo nl2br("Method: " . self::getMethod() . "\n");
    }
}
?>