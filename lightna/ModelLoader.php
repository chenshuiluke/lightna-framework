<?php
namespace Lightna\Database;
class ModelLoader{
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