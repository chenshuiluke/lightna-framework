<?php
namespace Lightna\Database;
class Model{
    protected $table = "model";
    protected $fields = [];

    protected function &string($name){
        $field = new Field($name, "string");
        return $this->createOrUpdateField($name, $field);
    }

    protected function &int($name){
        $field = new Field($name, "int");
        return $this->createOrUpdateField($name, $field);
    }

    protected function &boolean($name){
        $field = new Field($name, "boolean");
        return $this->createOrUpdateField($name, $field);
    }

    protected function &createOrUpdateField($name, $newField){
        if(!isset($this->fields[$name])){
            $this->fields[$name] = $newField;
        }
        else{
            $this->fields[$name] = $newField;
        }
        return $this->fields[$name];
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

    public function setFieldValue($name, $value){
        $this->setExistingFieldValue($name, $value);
    }

    public function saveNew(){
        $queryString = "INSERT INTO $this->table (";
        $size = count($this->fields);
        $fields = array_values($this->fields);

        $values = [];

        for($counter = 0; $counter < $size; $counter++){
            $field = $fields[$counter];
            $queryString .= $field->getName();
            if($counter !== ($size - 1)){
                $queryString .= ", ";
            }
        }
        $queryString .= ") VALUES ( ";

        for($counter = 0; $counter < $size; $counter++){
            $field = $fields[$counter];
            array_push($values, $field->getValue());
            $queryString .= "?";
            if($counter !== ($size - 1)){
                $queryString .= ", ";
            }
        }
        $queryString .= ");";
        //var_dump($fields);
        //var_dump($values);
        //echo $queryString;
        ORM::runQuery($queryString, $values);
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
        //echo $queryString;
        ORM::runQuery($queryString);
    }

    public function find($keyValArray = []){
        $size = count($keyValArray);
        $queryString = "SELECT * FROM $this->table ";
        $keys = array_keys($keyValArray);
        $values = [];
        if($size > 0){
            $queryString .= "WHERE";
            for($counter = 0; $counter < $size; $counter++){
                $fieldName = $keys[$counter];
                if(!$this->checkIfFieldExists($fieldName)){
                    throw new Exception("Field $fieldName does not exist in the model $this->model.
                    Check the model constructor to see if it exists.");
                }
                $queryString .= " $keys[$counter] = ?";
                $value = $keyValArray[$keys[$counter]];
                //echo nl2br("$value\n");
                array_push($values, $keyValArray[$keys[$counter]]);
                if($counter < ($size - 1)){
                    $queryString .= " AND";
                }
            }
        }
        $queryString .= ";";

        return ORM::runQuery($queryString, $values);
    }

    public function findAll(){
        $queryString = "SELECT * FROM $this->table ;";
        return ORM::runQuery($queryString);
    }

    public function delete($keyValArray = []){
        $values = [];
        $size = count($keyValArray);
        $keys = array_keys($keyValArray);
        $queryString = "DELETE FROM $this->table WHERE";
        if($size > 0){
            for($counter = 0; $counter < $size; $counter++){
                $fieldName = $keys[$counter];
                if(!$this->checkIfFieldExists($fieldName)){
                    throw new Exception("Field $fieldName does not exist in the model $this->model.
                    Check the model constructor to see if it exists.");
                }
                $queryString .= " $keys[$counter] = ?";
                $value = $keyValArray[$keys[$counter]];
                //echo nl2br("$value\n");
                array_push($values, $keyValArray[$keys[$counter]]);
                if($counter < ($size - 1)){
                    $queryString .= " AND";
                }
            }
            ORM::runQuery($queryString, $values);
        }
        else if(Config::getIsInDebugMode()){
            return Response::respondQuick("Please specify criteria for the records you want to delete.");
        }
        
    }

    public function update($keyValArray, $updateKeyValArray){
        
        $queryString = "UPDATE $this->table SET";        
        $keys = array_keys($keyValArray);
        $updateArr = array_values($updateKeyValArray);
        $size = count($updateArr);
        $values = [];
        //var_dump($updateKeyValArray);
        if($size > 0){
            for($counter = 0; $counter < $size; $counter++){
                //var_dump($updateArr[$counter]);
                $originalField = $updateArr[$counter]['originalField'];

                if(!$this->checkIfFieldExists($originalField)){
                    throw new Exception("Field $originalField does not exist in the model $this->model.
                    Check the model constructor to see if it exists.");
                }

                $newValue = $updateArr[$counter]['newValue'];
                $queryString .= " $originalField = ? ";
                array_push($values, $newValue);
                if($counter < ($size - 1)){
                    $queryString .= " , ";
                }
            }
        }
        $size = count($keys);
        if($size > 0){
            $queryString .= " WHERE ";
            for($counter = 0; $counter < $size; $counter++){
                $fieldName = $keys[$counter];
                if(!$this->checkIfFieldExists($fieldName)){
                    throw new Exception("Field $fieldName does not exist in the model $this->model.
                    Check the model constructor to see if it exists.");
                }

                $queryString .= " $fieldName  = ? ";

                $fieldValue = $keyValArray[$keys[$counter]];
                array_push($values, $fieldValue);

                if($counter < ($size - 1)){
                    $queryString .= " AND ";
                }
            }
            $queryString .= ";";
            // echo $queryString;
            // var_dump($values);
            ORM::runQuery($queryString, $values);
        }
        else if(Config::getIsInDebugMode()){
            return Response::respondQuick("Please specify criteria for the records you want to delete.");
        }            
    }
    //Checks to see if the passed field name exists in the model
    private function checkIfFieldExists($name){
        foreach($this->fields as $field){
            if($field->getName() === $name){
                return true;
            }
        }
        return false;
    }
}
?>