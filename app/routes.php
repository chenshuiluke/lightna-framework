<?php
use Lightna\Router;
use Lightna\Response;

Router::get('/', function(){
    return Response::respondQuick("Welcome to the Lightna framework!");
});

Router::get('/hello', 'ExampleController::index');
?>