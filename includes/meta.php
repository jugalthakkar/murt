<?php
/**
 * Description of meta
 *
 * @author Jugal
 */
class meta {

    public static function update($name,$newValue) {
        $meta=R::findOne(self::$tableName, "name=:name", array(':name' => $name));
        $meta->value=$newValue;
        R::store($meta);
    }

    private static $tableName = "metatable";

    public static function getValue($name) {
        try {            
            return R::findOne(self::$tableName, "name=:name", array(':name' => $name))->value;            
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            die("Database connection failed..." . mysql_error() . '<br/><a href="PhotoGallery.php">GO BACK</a>');
        }
    }

}

?>