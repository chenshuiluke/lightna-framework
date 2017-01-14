<?php
namespace Lightna\BuiltinModels;
class LightnaLogger extends \Lightna\Database\Model{
    public function __construct($keyValArray = []){
        $this->table = "lightna_logs";
        $this->string("text")->notNull();
        $this->string("time")->notNull();
        $this->doLogging = false;
        $this->create($keyValArray);
        
    }

    public static function onLoad(){
        $obj = new self();
        $obj->createTable();     
    }
}