<?php
namespace Lightna;
use Lightna\Response;

class View{
    private $name;
    private $baseDir = "../app/views/";
    private $content;
    function __construct($name){
        $this->name = $name . ".html";
        $directoryContents = scandir($this->baseDir);

        foreach($directoryContents as $file){
            if($file === $this->name){
                $this->content = file_get_contents($this->baseDir . $this->name);
                $response = new Response(200, $this->content);
                return $response->respond();
            }
        }
        throw new Exception("$this->name not found in app/views!");
    }
}
?>