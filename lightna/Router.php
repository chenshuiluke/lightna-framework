<?php
namespace Lightna;
define('APACHE_MIME_TYPES_URL','http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types');
class Router{
    private static $allRoutes = [];
    private static $getRoutes = [];
    private static $postRoutes = [];
    private static $putRoutes = [];
    private static $deleteRoutes = [];

    

    static function generateUpToDateMimeArray($url){
        $s=array();
        foreach(@explode("\n",@file_get_contents($url))as $x)
            if(isset($x[0])&&$x[0]!=='#'&&preg_match_all('#([^\s]+)#',$x,$out)&&isset($out[1])&&($c=count($out[1]))>1)
                for($i=1;$i<$c;$i++)
                    $s[]='&nbsp;&nbsp;&nbsp;\''.$out[1][$i].'\' => \''.$out[1][0].'\'';
        return @sort($s)?'$mime_types = array(<br />'.implode($s,',<br />').'<br />);':false;
    }

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
                //echo "MATCHED";
                return;
            }
        }
        $pathInfo = pathinfo($uri);
        $extension = isset($pathInfo['extension']) ? $pathInfo['extension'] : null;
        if(isset($extension) && ($extension !== "html" && $extension !== "php")){
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
            $response->setLocation($fileName);
            return $response->respond();
        }
        else{
            return Response::respondQuick(nl2br("No route defined for " . 
                    Request::getMethod() .  " " .  Request::getURI()));            
        }
        
        
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
            case 'DELETE':
                self::matchURI(self::$deleteRoutes, $uri);
            break;
        }
    }
}
?>