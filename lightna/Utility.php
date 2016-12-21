<?php
namespace Lightna;

class Utility{
    public static $mimeTypes = [];
    public static function onLoad(){
        if(!isset($_SESSION['mimeTypes'])){
            $handle = fopen("mime.types", "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $line = trim($line);
                    $mimeData = explode(" ", $line);
                    //var_dump($line);
                    //var_dump($mimeData);
                    //echo nl2br("\n");
                    self::$mimeTypes[$mimeData[1]] = $mimeData[0];
                }

                fclose($handle);
                $_SESSION['mimeTypes'] = self::$mimeTypes;
            } else {
                // error opening the file.
            }     
        }
    
    }
}
?>