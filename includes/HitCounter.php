<?php

require_once('rb.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of meta
 *
 * @author Jugal
 */
class HitCounter {

    private static $tableName = "hitcounts";

    static function getHitCountForURI($uri) {               
        $counter = R::findOne(self::$tableName, "uri=:uri", array(':uri' => $uri));
        if ($counter == null) {
            $counter = R::dispense(self::$tableName);
            $counter->uri = $uri;
            $counter->count = 1;
        } else {
            $counter->count++;
        }
        R::store($counter);        
        return $counter->count;        
        //return array_shift($results);
    }

    public static function getTotalHits() {
        R::setup('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $sql = "SELECT SUM(`Count`) FROM " . self::$tableName;
        $count= R::getCell($sql);        
        R::close();
        return $count;
    }

    public static function getHitCount() {
        return self::getHitCountForURI($_SERVER['PHP_SELF']);
    }

}

?>
