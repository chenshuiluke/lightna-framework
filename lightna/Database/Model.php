<?php
namespace Lightna\Database;
class Model{
    protected $table = "model";
    protected $fields = [];

    protected function string($name){
        $field = new Field($name, "string");
        $this->createOrUpdateField($name, $field);
    }

    protected function int($name){
        $field = new Field($name, "int");
        $this->createOrUpdateField($name, $field);
    }

    protected function boolean($name){
        $field = new Field($name, "boolean");
        $this->createOrUpdateField($name, $field);
    }

    protected function createOrUpdateField($name, $newField){
        if(!isset($this->fields[$name])){
            $this->fields[$name] = $newField;
        }
        else{
            $this->fields[$name]->setValue($newField->getValue());
        }
    }

    protected function setExistingFieldValue($name, $value){
        if(isset($this->fields[$name])){
            $this->fields[$name]->setValue($value);
        }
    }

    protected function create($keyValArray){
        $this->createTable();
        foreach($keyValArray as $fieldName => $fieldValue){
            $this->setExistingFieldValue($fieldName, $fieldValue);
        }

    }

    public function saveNew(){
        $queryString = "INSERT INTO $this->table (";
        $size = count($this->fields);
        $fields = array_values($this->fields);
        for($counter = 0; $counter < $size; $counter++){
            $field = $fields[$counter];
            $queryString .= $field->getName();
            if($counter !== ($size - 1)){
                $queryString .= ", ";
            }
        }
        $queryString .= ") VALUES ( ";
        echo $queryString;
    }

    protected function createTable(){
        $queryString = "CREATE TABLE IF NOT EXISTS $this->table (";
        $size = count($this->fields);
        $fields = array_values($this->fields);
        for($counter = 0; $counter < $size; $counter++){
            $field = $fields[$counter];
            $queryString .= $field->sqlCreate();

            if($counter !== ($size-1)){
                //Near the end of the loop
                $queryString .= ",";
            }
        }
        $queryString .= ");";
        echo $queryString;
    }
}
?>