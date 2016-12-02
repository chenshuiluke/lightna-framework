<?php
namespace Lightna;
class Config{
    private static $database_user;
    private static $database_password;
    private static $database_host;
    private static $database_name;

    private static $app_name = "TOBESET"; //To be set by the user.

    public static function onLoad(){
        if(getenv('lightna_database_user') === false){
            echo "No environment variable was found for the Lightna database user.\n";
        }
        else{
            $database_user = getenv('lightna_database_user');
        }

        if(getenv('lightna_database_password') === false){
            echo "No environment variable was found for the Lightna database password.\n";
        }
        else{
            self::$database_user = getenv('lightna_database_password');
        }

        if(getenv('lightna_database_host') === false){
            echo "No environment variable was found for the Lightna database host.\n";
        }
        else{
            self::$database_user = getenv('lightna_database_host');
        }

        if(getenv('lightna_database_name') === false){
            echo "No environment variable was found for the Lightna database name.\n";
        }
        else{
            self::$database_user = getenv('lightna_database_name');
        }

        if(!isset(self::$app_name)){
            echo "The app name is NOT set!\n";
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
}
?>