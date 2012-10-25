<?php
require_once('DBEntityTemplate.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of meta
 *
 * @author Jugal
 */
class HitCounter extends DBEntityTemplate {
    

    protected static function getTableName() {
        return "hit_counts";
    }
    protected static function getDBFields() {
        return array('Id','URI', 'Count');
    }

    public $URI;
    public $Count;
    static function getHitCountForURI($uri) {
        $sql="SELECT * FROM `" . static::getTableName() . "` WHERE `URI`='" . $uri . "'";
        $hitCounts = array_shift(self::find_by_sql($sql));
        if($hitCounts!=null) {
            $hitCounts->Count++;
            $hitCounts->save();
            return $hitCounts->Count;
        }
        $hitCounts=new HitCounter();
        $hitCounts->URI=$uri;
        $hitCounts->Count=1;
        $hitCounts->save();
        return $hitCounts->Count;
    }

    public static function getTotalHits() {
        $sql="SELECT SUM(`Count`) FROM " . static::getTableName();
        global $database;
        $result=$database->fetch_array($database->query($sql));
        return array_shift($result);
    }

    public static function getHitCount() {
        return self::getHitCountForURI($_SERVER['PHP_SELF']);
    }
}

?>
