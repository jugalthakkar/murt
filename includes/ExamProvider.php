<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExamProvider
 *
 * @author Jugal
 */
class ExamProvider {

    public static function getResult($postFields)
    {
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

    public static function updateOnline()
    {
        if (!UPDATE_MODE) return;
        $currTime = time();
        $timeSinceLastUpdateInSecs = $currTime - meta::getValue("last_update_time");
        if ($timeSinceLastUpdateInSecs / 60 < 2)
        {
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
            foreach ($eles as $ele)
            {
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

}
