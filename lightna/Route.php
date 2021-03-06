<?php
/**
 * Represents an object that is to be matched to a URI by Router.php
 */
namespace Lightna;
/**
 * A route is an object that will be matched to a URI by Router.php.
 * Routes are created by Router.php to match a particular expected URI.
 * Upon being matched, Router.php will call the callback of the Route object.
 */
class Route{
    /**
     * The HTTP method that the route is to be matched with.
     * Can be GET/POST/PUT/DELETE.
     * @var string
     */
    private $method;
    /**
     * The URI or path that the route is to be matched with.
     * @var string
     */
    private $uri;
    /**
     * The callback that is to be called when this route is matched.
     * @var [type]
     */
    private $callback;
  /**
   * Creates a new Route object.
   * @param string $method   The HTTP method that the route is to be matched with.
   * @param string $uri      The URI or path that the route is to be matched with.
   * @param callable $callback The callback that is to be called when this route is matched.
   */
    function __construct($method, $uri, $callback){
        $this->method = $method;
        $this->uri = $uri;
        $this->callback = $callback;
    }
    /**
     * Gets the router's URI
     * @return string The URI the router is to be matched with.
     */
    function getURI(){
        return $this->uri;
    }
    /**
     * Returns the callback that is to be called once the router is matched.
     * @return callable The callback that is to be called once the router is matched.
     */
    function getCallback(){
        return $this->callback;
    }
    /**
     * Returns the HTTP method that the route is to be matched with.
     * @return string  The HTTP method that the route is to be matched with.
     */
    function getMethod(){
        return $this->method;
    }
}
?>
