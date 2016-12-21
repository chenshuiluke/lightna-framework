<?php
namespace Lightna;
session_start();
//phpinfo();
//echo "HI";

try{
    require_once('load.php');
    //phpinfo();

    
    //Due to the .htaccess file, all requests are rerouted to this file.
    Utility::onLoad();
    Config::onLoad();
    Request::onLoad();
    Database\ORM::onLoad();
    if(Config::getIsInDebugMode()){
       // Request::printContents();
    }


    Router::match(Request::getMethod(), Request::getUri());
}
catch(\Exception $exc){
    if(Config::getIsInDebugMode()){
        return Response::respondQuick($exc, 500);
    }
    else{
        return Response::respondQuick("An error has occurred.", 500);
    }
}

?>