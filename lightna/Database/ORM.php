<?php
namespace Lightna\Database;
use Lightna\Config;
use PDO;
use Lightna\Response;

class ORM{
    private static $pdo;
    public static function onLoad(){
        $dsnPrefix = Config::getDatabaseType();
        
        if($dsnPrefix === "mysql" || $dsnPrefix === "pgsql"){
            $host = Config::getDatabaseHost();
            $user = Config::getDatabaseUser();
            $password = Config::getDatabasePassword();
            $dbName = Config::getDatabaseName();

            // var_dump($host);
            // var_dump($user);
            // var_dump($password);
            // var_dump($dbName);

            if(isset($host) && isset($user) && isset($password) && isset($dbName)){
                $dsn = "$dsnPrefix:host=$host;dbname=$dbName;charset=utf8";

                $opt = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                self::$pdo = new PDO($dsn, $user, $password, $opt);
                
            }
            else if(Config::getIsInDebugMode()){
                echo nl2br("Please ensure all the database configuration variables in config.php are set!\n");
            }

            
        }
    }

    public static function runQuery($queryString, $values = []){
        $runner = self::$pdo->prepare($queryString);
        $runner->execute($values);
        $rows = [];
        while($row = $runner->fetch(PDO::FETCH_ASSOC)){
            array_push($rows, $row);
        }
        return $rows;
    }
}
?>