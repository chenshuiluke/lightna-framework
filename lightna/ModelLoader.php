<?php
/**
 * Creates model tables on startup.
 */
namespace Lightna\Database;
/**
 * ModelLoader scans certain directories, e.g. app/models for models at startup and creates their tables.
 *
 */


class ModelLoader{
    /**
     * Creates tables for all models on startup.
     */    
    public static function loadModels(){
        foreach (glob('../app/models/*.php') as $file)
        {
            require_once $file;
            // get the file name of the current file without the extension
            // which is essentially the class name
            $class = basename($file, '.php');

            if (class_exists($class))
            {
                $obj = new $class;
                $obj->createTable();
                lightnaLog("Registering Model: " . $file);
            }
        }
    }
}

?>