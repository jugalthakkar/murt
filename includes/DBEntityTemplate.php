<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of DBEntityTemplate
 *
 * @author Jugal
 */
abstract class DBEntityTemplate {

    protected static abstract function getTableName();
    protected static abstract function getDBFields();


    public $Id;
    
    public static function find_all($orderby='id ASC') {
        return self::find_by_sql("SELECT * FROM ".static::getTableName() . " ORDER BY {$orderby}");
    }

    public static function find_by_sql($sql="") {
        global $database;
        $exam_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($exam_set)) {
            $object_array[] = self::instantiate($row);
        }
        return $object_array;
    }

    public static function find_by_id($id=0) {
        $exam_array = self::find_by_sql("SELECT * FROM ".static::getTableName()." WHERE id={$id} LIMIT 1");
        return !empty($exam_array) ? array_shift($exam_array) : false;
    }

    public static function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM ".static::getTableName();
        $exam_set = $database->query($sql);
        $row = $database->fetch_array($exam_set);
        return array_shift($row);
    }

    protected function attributes() {
// return an array of attribute names and their values
        $attributes = array();
        foreach(static::getDBFields() as $field) {
            if(property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    private function has_attribute($attribute) {
// We don't care about the value, we just want to know if the key exists
// Will return true or false
        return array_key_exists($attribute, $this->attributes());
    }

    private static function instantiate($record) {
// Could check that $record exists and is an array
        $object = new static;

// Simple, long-form approach:
// $object->Id 		= $record['id'];
// $object->name 	= $record['name'];
// ...
// ...


// More dynamic, short-form approach:
        foreach($record as $attribute=>$value) {
            if($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
// sanitize the values before submitting
// Note: does not alter the actual value of each attribute
        foreach($this->attributes() as $key => $value) {
            if($value!=NULL)
                $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }

    public function save() {
// A new record won't have an id yet.
        return (isset($this->Id) ? $this->update() : $this->create());
    }

    public function create() {
        global $database;
// Don't forget your SQL syntax and good habits:
// - INSERT INTO table (key, key) VALUES ('value', 'value')
// - single-quotes around all values
// - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO ".static::getTableName()." (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if($database->query($sql)) {
            $this->Id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        global $database;
// Don't forget your SQL syntax and good habits:
// - UPDATE table SET key='value', key='value' WHERE condition
// - single-quotes around all values
// - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE ".static::getTableName()." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=". $database->escape_value($this->Id);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public function delete() {
        global $database;
// Don't forget your SQL syntax and good habits:
// - DELETE FROM table WHERE condition LIMIT 1
// - escape all values to prevent SQL injection
// - use LIMIT 1
        $sql = "DELETE FROM ".static::getTableName();
        $sql .= " WHERE id=". $database->escape_value($this->Id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;

// NB: After deleting, the instance of User still
// exists, even though the database entry does not.
// This can be useful, as in:
//   echo $user->first_name . " was deleted";
// but, for example, we can't call $user->update()
// after calling $user->delete().
    }
}
?>
