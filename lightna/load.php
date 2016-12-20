<?php

spl_autoload_register(function($className){

    $versionsToTry = [];
    $versionsToTry['originalClassName'] = $className;
    $versionsToTry['lowerCaseClassName'] = strtolower($className);
    $versionsToTry['classNameWithoutNamespace'] = substr($className, strrpos($className, '\\') + 1);
    $versionsToTry['classNameWithoutNamespaceLowerCase'] = strtolower($versionsToTry['classNameWithoutNamespace']);
    
    foreach($versionsToTry as $classNameVersion){
        @include_once($classNameVersion . '.php');
        @include_once('../app/' . $classNameVersion . '.php');
        @include_once('../app/controllers/' . $classNameVersion . '.php');
        @include_once('../app/models/' . $classNameVersion . '.php');

    }


});

include_once('../app/config.php');
include_once('../app/routes.php');
?>