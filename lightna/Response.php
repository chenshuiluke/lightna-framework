<?php

/**
 * Handles most responses.
 */
namespace Lightna;

/**
 * Response is a class used to return response data to the client.
 *
 * Response is a class that is used to set the content type, content and status
 * code of responses that are sent to the client. In
 *
 *
 *
 */

class Response{
    /** @var int The status code of the response. */
    private $statusCode;
    /** @var string The content of the response. */
    private $content;
    /** @var string The value for the content type header of the response. */
    private $contentType;
    /** @var string The location of the file on the filesystem that is being served
      by the response.
    */
    private $location;

    /**
     * Used to create a response object.
     * @param int $statusCode The desired status code.
     * @param string $content The desired content.
     *
     */

    function __construct($statusCode = 200, $content = ""){
        $this->statusCode = $statusCode;
        $this->content = $content;
    }

    /**
     * Sets the status code of the response object.
     * @param int $statusCode The desired status code.
     *
     */
    public function setStatusCode($statusCode){
        $this->statusCode = $statusCode;
    }

    /**
     * Sets the content of the response object.
     * @param string $content The desired content.
     */

    public function setContent($content){
        $this->content = $content;
    }

    /**
     * Sets the desired content type header of the response object.
     * @param string $type The desired content type.
     */

    public function setContentType($type){
        $this->contentType = $type;
    }

    /**
     * Sets the location of the file to serve.
     * @param string $location The location of the file to serve.
     */

    public function setLocation($location){
        $this->location = $location;
    }

    /**
     * Converts the response's content to JSON and sets the appropriate content type header.
     */

    public function convertContentToJson(){
        header('Content-Type: application/json');
        $this->content = json_encode($this->content);
    }

    /**
     * Sends the appropriate data to the client by setting the desired (if any)
     * content type, serving a file from the location variable, setting the
     * http_response_code and sending the content to the client.
     */

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

    /**
     * An method to quickly generate and send a response in-place.
     * @param string $content The desired content.
     * @param int $statusCode The desired status code.
     */

    public static function respondQuick($content, $statusCode = 200){

        http_response_code($statusCode);
        echo $content;
    }
}
?>
