<?php
use Lightna\Response;
class UserController{
    static function index(){
        return Response::respondQuick("Hello!");
    }
    static function create(){
        $user = new UserModel();
        $user->saveNew();
    }
}
?>