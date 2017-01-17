<?php
namespace Lightna;
class Config{
    private static $database_user;
    private static $database_password;
    private static $database_host;
    private static $database_name;
    private static $database_type = "mysql"; //mysql or pgsql
    private static $isInDebugMode = true;
    
    private static $app_name = "Lightna framework"; //To be set by the user.

    public static function onLoad(){
        if(!isset(self::$database_user) && getenv('lightna_database_user') === false){
            if(Config::getIsInDebugMode()){
                echo nl2br("No environment variable was found for the Lightna database user.\n");
            }            
        }
        else if(getenv('lightna_database_user') !== false){
            self::$database_user = getenv('lightna_database_user');
        }

        if(!isset(self::$database_password) && getenv('lightna_database_password') === false){
            if(Config::getIsInDebugMode()){
                echo nl2br("No environment variable was found for the Lightna database password.\n");
            }            
        }
        else if(getenv('lightna_database_password') !== false){
            self::$database_password = getenv('lightna_database_password');
        }

        if(!isset(self::$database_host) && getenv('lightna_database_host') === false){
            if(Config::getIsInDebugMode()){
                echo nl2br("No environment variable was found for the Lightna database host.\n");
            }            
        }
        else if(getenv('lightna_database_host') !== false){
            self::$database_host = getenv('lightna_database_host');
        }

        if(!isset(self::$database_name) && getenv('lightna_database_name') === false){
            if(Config::getIsInDebugMode()){
                echo nl2br("No environment variable was found for the Lightna database name.\n");
            }            
        }
        else if(getenv('lightna_database_name') !== false){
            self::$database_name = getenv('lightna_database_name');
        }

        if(!isset(self::$app_name)){
            if(Config::getIsInDebugMode()){
                echo nl2br("The app name is NOT set!\n");
            }            
        }
        
        
    }

    public static function getAppName(){
        return self::$app_name;
    }

    public static function getDatabaseUser(){
        return self::$database_user;
    }

    public static function getDatabasePassword(){
        return self::$database_password;
    }

    public static function getDatabaseHost(){
        return self::$database_host;
    }

    public static function getDatabaseName(){
        return self::$database_name;
    }

    public static function getIsInDebugMode(){
        return self::$isInDebugMode;
    }

    public static function getDatabaseType(){
        return self::$database_type;
    }
}
?>