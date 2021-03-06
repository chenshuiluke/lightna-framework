<?php
/**
 * Model abstracts a lot of database CRUD functionality.
 *
 */
namespace Lightna\Database;
/**
 * Model abstracts a lot of database CRUD functionality so the user won't need to
 * write any SQL. Any user-created models should extend this class.
 */
class Model{
    /**
     * The name of the table that this model belongs to.
     * @var string
     */
    protected $table = "model";
    /**
     * An array of field objects that each represent a column.
     * @var Field
     */
    protected $fields = [];
    /**
     * Determines if this class will call any lightnaLog().
     * @var boolean
     */
    protected $doLogging = true;
    /**
     * Creates/updates and returns a Field of type string
     * @param  string $name The name of the field (name of the column).
     * @return Field       The newly created or updated field.
     */
     
    protected function &string($name){
        $field = new Field($name, "string");
        return $this->createOrUpdateField($name, $field);
    }
    /**
     * Creates/updates and returns a Field of type int
     * @param  string $name The name of the field (name of the column).
     * @return Field       The newly created or updated field.
     */
    protected function &int($name){
        $field = new Field($name, "int");
        return $this->createOrUpdateField($name, $field);
    }
    /**
     * Creates/updates and returns a Field of type boolean
     * @param  string $name The name of the field (name of the column).
     * @return Field       The newly created or updated field.
     */
    protected function &boolean($name){
        $field = new Field($name, "boolean");
        return $this->createOrUpdateField($name, $field);
    }
    /**
     * Either adds a field to the list of fields or updates an existing one.
     * Returns the instance of the field.
     * @param  string $name     The name of the field (name of the column).
     * @param  Field $newField The new field to add to the list of fields.
     * @return Field           The newly updated or added field.
     */
    protected function &createOrUpdateField($name, $newField){
        $this->fields[$name] = $newField;

        return $this->fields[$name];
    }
    /**
     * Updates an existing field's value.
     * @param string $name  Name of the field to update.
     * @param mixed $value The value of the field to set.
     */
    protected function setExistingFieldValue($name, $value){
        if(isset($this->fields[$name])){
            $this->fields[$name]->setValue($value);
        }
    }
  /**
   * Initializes items in the field list with values from $keyValArray. By the time this is called, some of the
   * creator methods (i.e. string(), boolean(), int()) would have been called
   * and added empty fields to the field array. So this function just takes an array
   * of new field names and values and initializes those existing fields.
   *
   * @param  array $keyValArray An associative array containing the names of
   * fields to initialize and the values to initialize them with.
   */
    protected function create($keyValArray){
        //$this->createTable();
        foreach($keyValArray as $fieldName => $fieldValue){
            $this->setExistingFieldValue($fieldName, $fieldValue);
        }

    }
  /**
   * A wrapper for setFieldValue();
   * @param string $name  Name of the field to update.
   * @param mixed $value New value of the field.
   */
    public function setFieldValue($name, $value){
        $this->setExistingFieldValue($name, $value);
    }

    /**
     * Saves all the fields in the model to the database by creating a new row.
     * To be called after the table has been created and the fields have been
     * initialized.
     */
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
  /**
   * Creates the table if it doesn't exist. The list of fields must have been created beforehand
   * and each field must have at least a name and a type before this function is to be called.
   *
   */
    public function createTable(){
        if($this->doLogging){
            lightnaLog("Creating $this->table");
        }
        
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
    /**
     * Finds a row whose fields match contents of $keyValArray
     * @param  array $keyValArray An associative array of field names and values.
     * For example, if you want to find a person that has a name of 'Bob' and
     * an age of 19, you should pass ['name' => 'Bob', 'age' => 19].
     * @return array              The row that has been found.
     */
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
    /**
     * Finds all rows of this model.
     * @return array All the rows of the model.
     */
    public function findAll(){
        $queryString = "SELECT * FROM $this->table ;";
        return ORM::runQuery($queryString);
    }
    /**
     * Deletes the row that matches the values in $keyValArray.
     * @param  array $keyValArray An associative array of field names and values.
     * For example, if you want to delete a person that has a name of 'Bob' and
     * an age of 19, you should pass ['name' => 'Bob', 'age' => 19].
     */
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
    /**
     * Updates rows that match $keyValArray with the new values in $updateKeyValArray.
     * @param  array $keyValArray An associative array of field names and values.
     * For example, if you want to update a person that has a name of 'Bob' and
     * an age of 19, you should pass ['name' => 'Bob', 'age' => 19].
     * @param  array $updateKeyValArray The values that should be used to update
     * the fields of the rows that match.
     * @return [type]                    [description]
     */
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
    /**
     * Checks to see if a field with a name of $name already exists in this model.
     * @param  string $name The name of the field to search for
     * @return boolean       True if the field already exists; false otherwise.
     */
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
