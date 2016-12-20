<?php
use Lightna\Database\Model;
class UserModel extends Model{
    public function __construct(){
        $this->string("name");
        $this->int("age");
        $this->create();
    }
}
?>