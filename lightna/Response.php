<?php
namespace Lightna;
class Response{
    private $statusCode;
    private $content;

    function __construct($statusCode = 200, $content = ""){
        $this->statusCode = $statusCode;
        $this->content = $content;
    }


    public function setStatusCode($statusCode){
        $this->statusCode = $statusCode;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function convertContentToJson(){
        header('Content-Type: application/json');
        $this->content = json_encode($this->content);
    }

    public function respond(){
        http_response_code($this->statusCode);
        echo $this->content;
    }

    public static function respondQuick($content, $statusCode = 200){
        http_response_code($statusCode);
        echo $content;
    }
}
?>