<?php
namespace Lightna;
require_once('load.php');
//Due to the .htaccess file, all requests are rerouted to this file.

Config::onLoad();
Request::onLoad();
if(Config::getIsInDebugMode()){
    Request::printContents();
}

Router::match(Request::getMethod(), Request::getUri());
?>