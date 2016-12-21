<?php
/**
 * Contains general utility code.
 */
namespace Lightna;
/**
 * Utility contains general utility code for tasks such as generating the
 * appropriate mime type for a file based on its extension.
 */
class Utility{
    /**
     * The array of extensions => mime types used by Router when serving files.
     * @var array $mimeTypes
     */
    public static $mimeTypes = [];

    /**
     * Populates the mime type array from the mime.types file.
     */

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
