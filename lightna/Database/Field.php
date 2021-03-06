<?php
/**
 * Fields replace database columns.
 */
namespace Lightna\Database;
/**
 * Fields replace database columns. Their name, value and type are used to generate
 * the SQL needed to created and manipulate them.
 */
class Field{
  /**
   * The name of the field
   * @var string
   */
    public $fieldName;
    /**
     * The type of the field. Should be equal to either "string", "int" or "boolean"
     * @var string
     */
    public $type;
    /**
     * The value of the field
     * @var mixed
     */
    public $fieldValue;
    /**
     * Determines if the field will have a PRIMARY KEY constraint when creating the table.
     * @var boolean
     */
    public $primary;
    /**
     * Determines if the field will have a NOT NULL constraint when creating the table.
     * @var boolean
     */
    public $nullable;
  /**
   * Creates a new field
   * @param string  $fieldName The name of the new field.
   * @param string  $type      The type of the new field.
   * @param boolean $primary   Determines the PRIMARY KEY constraint.
   * @param boolean $nullable  Determines the NOT NULL constraint.
   */
    function __construct($fieldName, $type, $primary = false, $nullable = true){
        $this->fieldName = $fieldName;
        $this->type = $type;
        $this->primary = $primary;
        $this->nullable = $nullable;
    }
  /**
   * Gets the field's name.
   * @return string The name of the field.
   */
    function getName(){
        return $this->fieldName;
    }
    /**
     * Gets the field's type.
     * @return string The type of the field.
     */
    function getType(){
        return $this->type;
    }
    /**
     * Gets the field's value.
     * @return mixed The value of the field.
     */
    function getValue(){
        return $this->fieldValue;
    }
    /**
     * Sets the field's value.
     * @param mixed $value The new value of the field.
     */
    function setValue($value){
        $this->fieldValue = $value;
    }
    /**
     * States that the field will have a PRIMARY KEY constraint.
     * @return Field The updated instance of the Field.
     */

    function &primary(){
        $this->primary = true;
        return $this;
    }
    /**
     * States that the field will have a NOT NULL constraint.
     * @return Field The updated instance of the Field.
     */
    function &nullable(){
        $this->nullable = true;
        return $this;
    }
    /**
     * States that the field will NOT have a NOT NULL constraint.
     * @return Field The updated instance of the Field.
     */
    function &notNull(){
        $this->nullable = false;
        return $this;
    }
    /**
     * Generates the SQL required to create this column in the database.
     * @return string The SQL required to create the column in the database.
     * E.g. "name VARCHAR(255) PRIMARY KEY NOT NULL"
     */
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
        if($this->primary){
            $queryString .= " PRIMARY KEY";
        }
        if(!$this->nullable){
            $queryString .= " NOT NULL";
        }
        return $queryString;
    }
}
?>
