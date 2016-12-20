<?php
namespace Lightna\Database;
class Field{
    public $fieldName;
    public $type;
    public $fieldValue;
    public $primary;
    public $nullable;

    function __construct($fieldName, $type, $primary = false, $nullable = true){
        $this->fieldName = $fieldName;
        $this->type = $type;
        $this->primary = $primary;
        $this->nullable = $nullable;
    }

    function getName(){
        return $this->fieldName;
    }

    function getType(){
        return $this->type;
    }

    function getValue(){
        return $this->value;
    }

    function setValue($value){
        $this->value = $value;
    }

    function sqlCreate(){
        $queryString = " ";
        $queryString .= $this->fieldName;
        //var_dump($this);
        switch($this->type){
            case "int":
                $queryString .= " INTEGER";
            break;
            case "string":
                $queryString .= " VARCHAR(255)";
                
            break;
            case "boolean":
                $queryString .= " BOOLEAN";
            break;      
            default:
                echo "No type";
            break;      
        }
        return $queryString;
    }
}
?>