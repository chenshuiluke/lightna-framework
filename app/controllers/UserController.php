<?php
use Lightna\Response;
use Lightna\Request;
class UserController{
    static function index(){
        return Response::respondQuick("Welcome user!!");
    }
    static function create(){
        $name = Request::getQueryValue('name');
        $age = Request::getQueryValue('age');
        $user = new UserModel();
        $user->setFieldValue('name', $name);
        $user->setFieldValue('age', $age);
        $user->saveNew();
    }
}
?>