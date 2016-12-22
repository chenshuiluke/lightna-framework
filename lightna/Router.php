<?php
/**
 * Stores all registered routes and handles route-to-request matching.
 * Also handles serving of files in app/views/
 */
namespace Lightna;
/**
 * Router stores all registered routes and handles route-to-request matching.
 * Also handles serving of files in app/views/
 */
class Router{
  /**
   * Contains each and every route that has been registered, no matter its type.
   * @var array $allRoutes
   */
    private static $allRoutes = [];
    /**
     * Contains all GET routes.
     * @var string $getRoutes
     */
    private static $getRoutes = [];
    /**
     * Contains all POST routes.
     * @var string $postRoutes
     */
    private static $postRoutes = [];
    /**
     * Contains all PUT routes.
     * @var string $putRoutes
     */
    private static $putRoutes = [];
    /**
     * Contains all DELETE routes.
     * @var string $deleteRoutes
     */
    private static $deleteRoutes = [];


    /**
     * [checkIfRouteExists description]
     * @param  Route $newRoute The route that will be checked to see if it already exists.
     * @return boolean           true if the route exists; false otherwise.
     */
    private static function checkIfRouteExists($newRoute){
        foreach(self::$allRoutes as $route){
            if($newRoute->getURI() === $route->getURI()){
                return true;
            }
        }
        return false;
    }
    /**
     * Adds a new route to the list of all routes and the list of GET routes.
     * @param  string $url      The URL that the route is registered for.
     * @param  callable $callback The method that the route will call once it has been matched.
     */
    public static function get($url, $callback){
        $newRoute = new Route('GET', $url, $callback);
        if(!self::checkIfRouteExists($newRoute)){
            array_push(self::$allRoutes, $newRoute);
            array_push(self::$getRoutes, $newRoute);
        }
        else if(Config::getIsInDebugMode()){
            Response::respondQuick(nl2br("Identical route was already registered for " .
            $newRoute->getMethod() . " " . $newRoute->getURI() . " !\n"), 400);
        }
    }
    /**
     * Adds a new route to the list of all routes and the list of POST routes.
     * @param  string $url      The URL that the route is registered for.
     * @param  callable $callback The method that the route will call once it has been matched.
     */
    public static function post($url, $callback){
        $newRoute = new Route('POST', $url, $callback);
        if(!self::checkIfRouteExists($newRoute)){
            array_push(self::$allRoutes, $newRoute);
            array_push(self::$postRoutes, $newRoute);
        }
        else if(Config::getIsInDebugMode()){
            Response::respondQuick(nl2br("Identical route was already registered for " .
            $newRoute->getMethod() . " " . $newRoute->getURI() . " !\n"), 400);
        }
    }
    /**
     * Adds a new route to the list of all routes and the list of PUT routes.
     * @param  string $url      The URL that the route is registered for.
     * @param  callable $callback The method that the route will call once it has been matched.
     */
    public static function put($url, $callback){
        $newRoute = new Route('PUT', $url, $callback);
        if(!self::checkIfRouteExists($newRoute)){
            array_push(self::$allRoutes, $newRoute);
            array_push(self::$putRoutes, $newRoute);
        }
        else if(Config::getIsInDebugMode()){
            Response::respondQuick(nl2br("Identical route was already registered for " .
            $newRoute->getMethod() . " " . $newRoute->getURI() . " !\n"), 400);
        }
    }
    /**
     * Adds a new route to the list of all routes and the list of DELETE routes.
     * @param  string $url      The URL that the route is registered for.
     * @param  callable $callback The method that the route will call once it has been matched.
     */
    public static function delete($url, $callback){
        $newRoute = new Route('DELETE', $url, $callback);
        if(!self::checkIfRouteExists($newRoute)){
            array_push(self::$allRoutes, $newRoute);
            array_push(self::$deleteRoutes, $newRoute);
        }
        else if(Config::getIsInDebugMode()){
            Response::respondQuick(nl2br("Identical route was already registered for " .
            $newRoute->getMethod() . " " . $newRoute->getURI() . " !\n"), 400);
        }
    }
    /**
     * Attempts to find the matching route for the request that was sent.
     * @param  array $routes An array of GET/POST/PUT/DELETE routes (whichever type is applicable based on the request method).
     * @param  string $uri    The URI to match.
     */
    private static function matchURI($routes, $uri){

        foreach($routes as $route){
            if($route->getURI() === $uri){
                $callback = $route->getCallback();

                $callback();
                //echo "MATCHED";
                return;
            }
        }
        $pathInfo = pathinfo($uri);
        //echo nl2br($uri."\n");
        $extension = isset($pathInfo['extension']) ? $pathInfo['extension'] : null;
        if(isset($extension)){
            $mimeTypes = $_SESSION['mimeTypes'];
            $fileName = '../app/views' . $uri;
            //var_dump($mimeTypes);
            //$contents = file_get_contents($fileName);
            $response = new Response(200);
            //echo $extension;
            if(isset($mimeTypes[$extension])){
                $response->setContentType('Content-Type: ' . $mimeTypes[$extension]);
            }
            else{
                echo "Unknown mimetype";
            }
            $response->setLocation($uri);
            return $response->respond();
        }
        else{
            return Response::respondQuick(nl2br("No route defined for " .
                    Request::getMethod() .  " " .  Request::getURI()));
        }


    }
    /**
     * Starts the matching of the URI to a route by determining its type
     * and passing the appropriate route list to matchURI()
     * @param  string $method The method of the request (GET/POST/PUT/DELETE).
     * @param  string $uri    The URI of the request
     */
    public static function match($method, $uri){
        switch($method){
            case 'GET':
                self::matchURI(self::$getRoutes, $uri);
            break;
            case 'POST':
                self::matchURI(self::$postRoutes, $uri);
            break;
            case 'PUT':
                self::matchURI(self::$putRoutes, $uri);
            break;
            case 'DELETE':
                self::matchURI(self::$deleteRoutes, $uri);
            break;
        }
    }
}
?>
