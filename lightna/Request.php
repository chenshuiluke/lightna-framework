<?php
/**
 * Deals with requests
 */
namespace Lightna;
/**
 * The Request class will always hold the data from the last/most recent request.
 */
class Request{
  /**
   * The full URL of the request.
   * @var string
   */
    private static $request_url;
    /**
     * The port of the request.
     * @var int
     */
    private static $port;
    /**
     * The host of the request.
     * @var string
     */
    private static $host;
    /**
     * The request protocol.
     * @var string
     */
    private static $protocol;
    /**
     * The URI or path of the request.
     * @var string
     */
    private static $uri;
    /**
     * The method of the request.
     * @var [type]
     */
    private static $method;
    /**
     * An array of the request's URL queries.
     * @var array
     */
    private static $queries = [];
    /**
     * An array of the request's JSON data.
     * @var array
     */
    private static $json = [];
    /**
     * An array of the requests' form data.
     * @var array
     */
    private static $form_data = [];

    //Code for getting the full URL was found here: http://stackoverflow.com/a/8891890
    /**
     * Parses the request into its component parts, i.e. the method, port, uri, etc.
     */
    private static function parseURL(){
        //A bunch of issets in case the script is being run from the commandline via php -f
        $server = $_SERVER;
        //echo $server['REQUEST_URI'];
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
        self::$queries = parse_url(self::$request_url, PHP_URL_QUERY);



        parse_str(self::$queries, self::$queries);
        self::$uri = parse_url(self::$request_url, PHP_URL_PATH);

        $lastCharacter = substr(self::$uri, -1);
        if($lastCharacter === "/" && strlen(self::$uri) > 1){
          self::$uri = substr(self::$uri, 0, -1);
          //echo self::$uri;
        }
    }
    /**
     * Checks to see if $str is a valid JSON string.
     * @param  string  $str String to test.
     * @return boolean      true if $str is a valid JSON string; false otherwise.
     */
    private static function isValidJSON($str) {
        json_decode($str);
        return strlen($str) && json_last_error() == JSON_ERROR_NONE;
    }
    /**
     * Converts the request json data string to an associative array.
     */
    private static function getJson(){
        $json = file_get_contents("php://input");
        if(self::isValidJSON($json)){
            self::$json = json_decode($json, true);
        }
    }
    /**
     * Sets the request instance's form and JSON data.
     */
    private static function getBodyData(){
        self::getJson();
        self::$form_data = $_POST;
    }
    /**
     * Returns the JSON of the request instance.
     * @return array JSON data.
     */
    public static function getJsonData(){
        return self::$json;
    }
    /**
     * Returns the form data of the request instance.
     * @return array Form data.
     */
    public static function getFormData(){
        return self::$form_data;
    }

    // function __construct(){
    //     $this->parseURL();
    // }

    /**
     * Starts the process of parsing the HTTP request and getting its data.
     */
    public static function onLoad(){
        self::parseURL();
        self::getBodyData();
    }
    /**
     * Gets the URL of the request instance.
     * @return string URL of the request instance.
     */
    public static function getURL(){
        return self::$request_url;
    }
    /**
     * Gets the port of the request instance.
     * @return int Port of the request instance.
     */
    public static function getPort(){
        return self::$port;
    }
    /**
     * Gets the host of the request instance.
     * @return string Host of the request instance.
     */
    public static function getHost(){
        return self::$host;
    }
    /**
     * Gets the URI or path of the request instance.
     * @return string URI or path of the request instance.
     */
    public static function getUri(){
        return self::$uri;
    }
    /**
     * Gets the method of the request instance.
     * @return string Method of the request instance.
     */
    public static function getMethod(){
        return self::$method;
    }
    /**
     * Gets the URL queries of the request instance.
     * @return array URL queries of the request instance.
     */
    public static function getQueries(){
        return self::$queries;
    }
    /**
     * Prints some of the contents of the request instance.
     */
    public static function printContents(){
        echo nl2br("URL: " . self::getURL() . "\n");
        echo nl2br("Port: " . self::getPort() . "\n");
        echo nl2br("Host: " . self::getHost() . "\n");
        echo nl2br("Uri: " . self::getUri() . "\n");
        echo "Queries ";
        print_r(self::getQueries());
        echo nl2br("\n");
        echo nl2br("Method: " . self::getMethod() . "\n");
    }
    /**
     * Gets a specific URL query value from the request instance
     * @param  string Name of the url query key.
     * @return string       URL query value.
     */
    public static function getQueryValue($name){
        return self::$queries[$name];
    }
    /**
     * Gets a specific form data value from the request instance
     * @param  string Name of the form data key.
     * @return string       form data value.
     */
    public static function getFormValue($name){
        return self::$form_data[$name];
    }
    /**
     * Gets a specific JSON value from the request instance
     * @param  string Name of the JSON key.
     * @return string       JSON data value.
     */
    public static function getJsonValue($name){
        return self::$json[$name];
    }
}
?>
