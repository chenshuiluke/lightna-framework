<?php
use Lightna\Router;
use Lightna\Response;
use Lightna\View;
Router::get('/', function(){
    return new View("users");
    return Response::respondQuick("Welcome to the Lightna framework!");
});

Router::get('/users/get', 'UserController::find');
Router::get('/users/get/all', 'UserController::findAll');
Router::post('/users/add', 'UserController::create');
Router::delete('/users/delete', 'UserController::delete');
Router::put('/users/update', 'UserController::update');
?>