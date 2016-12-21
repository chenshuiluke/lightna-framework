<?php
namespace Lightna;
try{
    //phpinfo();
    require_once('load.php');
    //Due to the .htaccess file, all requests are rerouted to this file.

    Config::onLoad();
    Request::onLoad();
    Database\ORM::onLoad();
    if(Config::getIsInDebugMode()){
        //Request::printContents();
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