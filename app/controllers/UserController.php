<?php
use Lightna\Response;
use Lightna\Request;
class UserController{
    static function index(){
        return Response::respondQuick("Welcome user!!");
    }
    static function create(){
        $name = Request::getFormValue('name');
        $age = Request::getFormValue('age');
        if(!isset($name) || !isset($age)){
            return Response::respondQuick("You forgot to enter the person's details", 400);
        }
        $user = new UserModel();
        $user->setFieldValue('name', $name);
        $user->setFieldValue('age', $age);
        $user->saveNew();
    }

    static function find(){
        $name = Request::getQueryValue('name');
        $age = Request::getQueryValue('age');

        if(!isset($name) || !isset($age)){
            return Response::respondQuick("You forgot to enter the person's details", 400);
        }

        $user = new UserModel(); 
        
        $result = $user->find(['name' => $name, 'age' => $age]);
        $response = new Response(200, $result);
        $response->convertContentToJson();
        return $response->respond();
    }

    static function findAll(){
        $user = new UserModel(); 
        
        $result = $user->findAll();
        $response = new Response(200, $result);
        $response->convertContentToJson();
        return $response->respond();
    }

    static function delete(){
        $name = Request::getQueryValue('name');
        $age = Request::getQueryValue('age');
        $user = new UserModel(); 
        
        $user->delete(['name' => $name, 'age' => $age]);
    }

    static function update(){
        $name = Request::getQueryValue('name');
        $age = Request::getQueryValue('age');
        $newName = Request::getQueryValue('newName');
        $newAge = Request::getQueryValue('newAge');

        if(!isset($name) || !isset($age) || !isset($newName) || !isset($newAge)){
            return Response::respondQuick("You forgot to enter the person's details", 400);
        }
        $user = new UserModel(); 
        
        $user->update(['name' => $name, 'age' => $age],
        [[
            'originalField' => 'name',
            'newValue' => $newName
        ],
        [
            'originalField' => 'age',
            'newValue' => $newAge
        ]]
        );
    }
}
?>