<?php
use Lightna\Router;
use Lightna\Response;

Router::get('/', function(){
    return Response::respondQuick("Welcome to the Lightna framework!");
});

Router::get('/users/get', 'UserController::find');
Router::post('/users/add', 'UserController::create');
Router::delete('/users/delete', 'UserController::delete');
Router::put('/users/update', 'UserController::update');
?>