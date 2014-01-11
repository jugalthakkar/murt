<?php

require_once("meta.php");
require_once("TwitterWrapper.php");

class exam {

    public static $counter = 0;
    private static $tableName = "exams";
    public $Id;
    public $ExamName;
    public $Discovered;

    public function create() {
        $exam = R::dispense(self::$tableName);
        $exam->name = $this->ExamName;
        $exam->discovered = $this->Discovered;
        $exam->exam_id = $this->Id;
        R::store($exam);
    }

    public function getURL() {
        return WEB_ROOT . 'result/' . $this->Id . '/' . $this->prettifyName() . '/';
//        return self::getURLforid($this->Id);
    }

    private static function getURLforid($eid) {
        return WEB_ROOT . 'exams/' . $eid . '/';
    }

    private function prettifyName() {
        $temp = str_replace('.', '', $this->ExamName);
        $temp = preg_replace("/[^a-zA-Z0-9 ]/", ' ', $temp);
        $temp = preg_replace('/\s+/', ' ', $temp);
        return urlencode(str_replace(' ', '-', trim($temp)));
    }

    public static function updateOnline() {
        $currTime = time();
        $timeSinceLastUpdateInSecs = $currTime - meta::getValue("last_update_time");
        if ($timeSinceLastUpdateInSecs / 60 < 2) {
            return;
        }
        require_once("myCurl.php");
        $examid = $maxid = self::FindLastid();
        do {
            $examid++;
            $URL = "http://results.mu.ac.in/choose_nob.php?exam_id=" . $examid;
            $curl = new mycurl($URL);
            $curl->createCurl();
            $domEle = str_get_html($curl->__tostring());
            $eles = $domEle->find('font[color=#blue]');
            $count = count($eles);
            foreach ($eles as $ele) {
                $exam = new exam();
                $exam->Id = $examid;
                $temp = str_replace("Results for ", "", $ele->innertext);
                $exam->ExamName = trim(str_replace(" held on  ", "", $temp));
                $exam->Discovered = time();
                $exam->create();
                $exam->Id = $examid;
                $exam->tweetMe();
            }
        } while ($count > 0);
        meta::update('last_update_time', time());
        return $maxid;
    }

    public static function GetLatestResultsByCount($count) {
        exam::updateOnline();

        $results = R::findAll(self::$tableName, "ORDER BY exam_id DESC LIMIT " . $count);
        return self::transformDBEntities($results);
    }

    public static function GetLatestResultsAfterId($ID) {
        exam::updateOnline();
        $results = R::find(self::$tableName, "exam_id > " . $ID . " ORDER BY exam_id DESC");
        return self::transformDBEntities($results);
    }

    public static function GetAll() {
        exam::updateOnline();
        $results = R::findAll(self::$tableName, " ORDER BY exam_id DESC");
        return self::transformDBEntities($results);
    }

    public static function GetByID($exam_id) {
        exam::updateOnline();
        $results = self::transformDBEntities(R::find(self::$tableName, " exam_id=:examID ",array(":examID"=>$exam_id)));
        return array_shift($results);
    }

    public static function GetLatestResultsAfterIdByCount($ID, $count) {
        exam::updateOnline();
        $results = R::find(self::$tableName, "exam_id between " . ($ID + 1) . " AND " . ($ID + $count) . " ORDER BY exam_id DESC");
        return self::transformDBEntities($results);
    }

    private static function transformDBEntities($dbEntities) {
        $exams = array();
        foreach ($dbEntities as $dbEntity) {
            $exam = new exam();
            $exam->Id = $dbEntity->exam_id;
            $exam->ExamName = $dbEntity->name;
            $exam->Discovered = $dbEntity->discovered;
            array_push($exams, $exam);
        }
        return $exams;
    }

    public static function getResult($postFields) {
        global $database;
        require_once("myCurl.php");
        $curl = new mycurl("http://results.mu.ac.in/get_resultb.php");
        $curl->setPost($postFields);
        $curl->createCurl();
        $domEle = str_get_html($curl->__tostring());
        $eles = $domEle->find('font[size=-1]');
        $output = str_replace("<br", "\n<br", array_shift($eles));

        return trim(strip_tags($output));
    }

    public static function FindLastid() {
        $lastId = R::getCell("SELECT MAX(exam_id) FROM " . self::$tableName);
        if ($lastId == null) {
            $lastId = START_EXAM_ID;
        }
        return $lastId;
    }

    public static function FindFirstid() {
        return R::getCell("SELECT MIN(exam_id) FROM " . self::$tableName);
    }

    public function tweetMe() {
        $link = $this->getURL();
        $linkLen = 20; // Twitter converts all links to length 20
        $examName = str_replace(".", " ", $this->ExamName);
        $examName = str_replace("  ", " ", $examName);
        $status = "#MumbaiUniversity #Result for #" . str_replace("-", "", $this->prettifyName()) . " @ " . $link;
        $len = strlen($status) - strlen($link) + $linkLen;
        if ($len > 140) {
            $examNameShortened = substr($examName, 0, 140 - ($linkLen + 1));
            $status = $examNameShortened . " " . $link;
        }
        TwitterWrapper::tweet($status);
    }

}

exam::updateOnline();
?>