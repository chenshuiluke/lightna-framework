<?php
use Lightna\Response;
class ExampleController{
    static function index(){
        return Response::respondQuick("Hello!");
    }
}
?>