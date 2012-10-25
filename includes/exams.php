<?php
require_once('DBEntityTemplate.php');
require_once("meta.php");
require_once("TwitterWrapper.php");


class exam extends DBEntityTemplate {
    public static $counter=0;

    protected static function getTableName() {
        return "exams";
    }

    protected static function getDBFields() {
        return  array('Id', 'ExamName', 'Discovered');
    }

    public $ExamName;
    public $Discovered;

    public function getURL() {
        return self::getURLforid($this->Id);
    }

    private static function getURLforid($eid) {
        return  WEB_ROOT . 'ExamDetails.php?exam_id=' . $eid;
    }

    public static function updateOnline() {
        $currTime=time();
        $lastUpdateTime=meta::getByKey("last_update_time");
        $timeSinceLastUpdateInSecs=$currTime-$lastUpdateTime->MetaValue;
        if($timeSinceLastUpdateInSecs/60<2) {
            return;
        }
        global $database;
        require_once("myCurl.php");
        $examid=$maxid=self::FindLastid();
        do {
            $examid++;
            $URL="http://results.mu.ac.in/choose_nob.php?exam_id=" . $examid;
            $curl=new mycurl($URL);
            $curl->createCurl();
            $domEle=str_get_html($curl->__tostring());
            $eles=$domEle->find('font[color=#blue]');
            $count=count($eles);
            foreach($eles as $ele) {
                $exam=new exam();
                $exam->Id=$examid;
                $temp=str_replace("Results for ", "", $ele->innertext);
                $exam->ExamName=trim(str_replace(" held on  ", "", $temp));
                $exam->Discovered=time();
                $exam->create();
                $exam->Id=$examid;
                $exam->tweetMe();
            }
        }while($count>0);
        $lastUpdateTime->MetaValue=time();
        $lastUpdateTime->save();
        return $maxid;
    }

    public static function GetLatestResultsByCount($count) {
        exam::updateOnline();
        $sql="SELECT * FROM " . static::getTableName() . " ORDER BY id DESC LIMIT " . $count;
        return self::find_by_sql($sql);
    }

    public static function GetLatestResultsAfterId($ID) {
        exam::updateOnline();
        $sql="SELECT * FROM " . static::getTableName() . " WHERE id > " . $ID . " ORDER BY id DESC";
        return self::find_by_sql($sql);
    }

    public static function GetLatestResultsAfterIdByCount($ID,$count) {
        exam::updateOnline();
        $sql="SELECT * FROM " . static::getTableName() . " WHERE id between " . ($ID+1) . " AND " . ($ID+$count) . " ORDER BY id DESC";
        return self::find_by_sql($sql);
    }

    public static function getResult($postFields) {
        global $database;
        require_once("myCurl.php");
        $curl=new mycurl("http://results.mu.ac.in/get_resultb.php");
        $curl->setPost($postFields);
        $curl->createCurl();
        $domEle=str_get_html($curl->__tostring());
        $eles=$domEle->find('font[size=-1]');
        $output=str_replace("<br","\n<br",array_shift($eles));

        return trim(strip_tags($output));
    }

    public static function FindLastid() {
        global $database;
        $row=$database->fetch_array($database->query("SELECT MAX(Id) FROM " . static::getTableName()));
        return array_shift($row);
    }

    public static function FindFirstid() {
        global $database;
        $row=$database->fetch_array($database->query("SELECT MIN(Id) FROM exams " . static::getTableName()));
        return array_shift($row);
    }

    public function tweetMe() {
        $link=$this->getURL();
        $linkLen=20; // Twitter converts all links to length 20
        $examName=str_replace(".", " ",  $this->ExamName);
        $examName=str_replace("  ", " ",  $examName);
        $status= "Result for " . $examName . " @ " . $link;
        $len=strlen($status)-strlen($link)+$linkLen;
        if($len>140) {
            $examNameShortened=substr($examName, 0,140-($linkLen+1));
            $status=$examNameShortened . " " . $link;
        }
        TwitterWrapper::tweet($status);
    }
}
?>