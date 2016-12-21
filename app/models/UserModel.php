<?php
use Lightna\Database\Model;
class UserModel extends Model{
    
    public function __construct($keyValArray = []){
        $this->table = "users";
        $this->string("name")->notNull()->primary();
        $this->int("age");
        $this->create($keyValArray);
        //var_dump($keyValArray);
    }
}
?>