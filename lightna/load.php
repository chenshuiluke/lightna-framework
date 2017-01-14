<?php
/**
 * Registers an autoloader that will search for any classes that haven't been loaded yet. Also defines a logging function.
 */
spl_autoload_register(function($className){

    $versionsToTry = [];
    $versionsToTry['originalClassName'] = $className;
    $versionsToTry['lowerCaseClassName'] = strtolower($className);
    $versionsToTry['classNameWithoutNamespace'] = substr($className, strrpos($className, '\\') + 1);
    $versionsToTry['classNameWithoutNamespaceLowerCase'] = strtolower($versionsToTry['classNameWithoutNamespace']);

    foreach($versionsToTry as $classNameVersion){
        @include_once($classNameVersion . '.php');
        @include_once('Database/' . $classNameVersion . '.php');
        @include_once('BuiltinModels/' . $classNameVersion . '.php');
        @include_once('../app/' . $classNameVersion . '.php');
        @include_once('../app/controllers/' . $classNameVersion . '.php');
        @include_once('../app/models/' . $classNameVersion . '.php');
        @include_once('../app/views/' . $classNameVersion . '.php');

    }


});

include_once('../app/config.php');
include_once('../app/routes.php');

function lightnaLog($text){
    try{
        $logger = new Lightna\BuiltinModels\LightnaLogger(['text' => $text,
            'time' => date('m/d/Y h:i:s a', time())]);
        $logger->saveNew();
    }
    catch(Exception $exc){

    }

}


?>
