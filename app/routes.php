<?php
use Lightna\Router;
use Lightna\Response;
use Lightna\View;

Router::get('/', function(){
    return new View("users");
});

Router::get('/privacy_policy.html', function(){
    return new View("privacy_policy");
});

Router::get('/docs', function(){
    return new View("docs/index");
});

Router::get('/users/get', 'UserController::find');
Router::get('/users/get/all', 'UserController::findAll');
Router::post('/users/add', 'UserController::create');
Router::delete('/users/delete', 'UserController::delete');
Router::put('/users/update', 'UserController::update');
?>
