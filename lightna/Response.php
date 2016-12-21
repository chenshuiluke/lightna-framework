<?php
namespace Lightna;
class Response{
    private $statusCode;
    private $content;
    private $contentType;
    private $location;

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

    public function setContentType($type){
        $this->contentType = $type;
    }

    public function setLocation($location){
        $this->location = $location;
    }

    public function convertContentToJson(){
        header('Content-Type: application/json');
        $this->content = json_encode($this->content);
    }

    public function respond(){
        if(isset($this->contentType)){
            //echo "Setting header: " . $this->contentType;
            header($this->contentType);
        }
        if(isset($this->location)){
            //header('Location: ' . $this->location);
            readfile($this->location);
        }
        http_response_code($this->statusCode);
        if(isset($this->content)){
            echo $this->content;
        }
        
    }

    public static function respondQuick($content, $statusCode = 200){

        http_response_code($statusCode);
        echo $content;
    }
}
?>