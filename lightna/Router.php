<?php
namespace Lightna;
class Router{
    private static $allRoutes = [];
    private static $getRoutes = [];
    private static $postRoutes = [];
    private static $putRoutes = [];
    private static $deleteRoutes = [];

    private static function checkIfRouteExists($newRoute){
        foreach(self::$allRoutes as $route){
            if($newRoute->getURI() === $route->getURI()){
                return true;
            }
        }
        return false;
    }
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

    private static function matchURI($routes, $uri){

        foreach($routes as $route){
            if($route->getURI() === $uri){
                $callback = $route->getCallback();
                
                $callback();
                echo "MATCHED";
                return;
            }
        }
        Response::respondQuick(nl2br("No route defined for " . 
                Request::getMethod() .  " " .  Request::getURI()));
        
    }

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
            case 'POST':
                self::matchURI(self::$postRoutes, $uri);
            break;
        }
    }
}
?>