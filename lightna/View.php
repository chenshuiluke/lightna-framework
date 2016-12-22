<?php
/**
 * Deals with rendering webpages
 */
namespace Lightna;
use Lightna\Response;
/**
 * View class essentially encapsulates an html in app/views
 * Returning a View will return the contents of the .html file it links to.
 */
class View{
    /**
     * Name of the view.
     * @var string
     */
    private $name;
    /**
     * Directory where views are located.
     * @var string
     */
    private $baseDir = "../app/views/";
    /**
     * The contents of the html file the View encapsulates.
     * @var [type]
     */
    private $content;
    /**
     * Returns the contents of the view's html file.
     * @param string $name Name of the View's html file, without the extension.
     */
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
        throw new \Exception("$this->name not found in $this->baseDir!");
    }
}
?>
