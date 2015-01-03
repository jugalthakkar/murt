<?php
require_once ('initialize.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SnapshotService
 *
 * @author Jugal
 */
class SnapshotService {

    //put your code here


    private static $fragments;

    static function Init()
    {
        self::$fragments = array('index' => '/', 'android' => '/android', 'visualization' => '/visualization', 'results' => '/results/300', 'result' => '/result/' . EXAM_ID_PLACEHOLDER . '/' . EXAM_NAME_PLACEHOLDER);
//        self::$pages = array('android' => 'android.html');
    }

    public static function GetSnapshot($hashFragment)
    {
        global $log;
        $log->logInfo('GetSnapshot - fragment: "' . $hashFragment . '"');
        if ($hashFragment == '' || $hashFragment == '/index')
        {
            $hashFragment = '/';
        }
        $tokens = explode('/', $hashFragment);
        $page = $tokens[1];
        if (!array_key_exists($page, self::$fragments))
        {
            $hashFragment = '/';
            $page = 'index';
        }
        else
        {
            $hashFragment = self::$fragments[$page];
        }
        $snapshotFile = SNAPSHOT_ROOT . $page . '.html';
        $log->logInfo('GetSnapshot - file: "' . $snapshotFile . '"');
        $output = file_get_contents($snapshotFile);
        if ($page == 'result')
        {
            $log->logInfo('GetSnapshot - EXAM_ID_PLACEHOLDER => "' . $tokens[2] . '"');
            $output = str_replace(EXAM_ID_PLACEHOLDER, $tokens[2], $output);
            $log->logInfo('GetSnapshot - EXAM_NAME_PLACEHOLDER => "' . $tokens[3] . '"');            
            $output = str_replace(EXAM_NAME_PLACEHOLDER, $tokens[3], $output);            
        }
        return $output;
    }

    public static function CreateSnapshot($fragment, $snapshotFile)
    {
        global $log;
        $log->logInfo('CreateSnapshot: ' . $fragment . '=>' . $snapshotFile);
        $cmd = PATH_TO_PHANTOM . ' --disk-cache=no ' . PATH_TO_PHANTOM_JS . ' \'' . BASE_URL . '#!' . $fragment . '\' 2>&1';
        $log->logInfo('CreateSnapshot - Command: ' . $cmd);
        $output=array();
        exec($cmd, $output,$retVal);
        //$log->logInfo('CreateSsnapshot - output: ' . $output);
        $log->logInfo('CreateSnapshot - status: ' . $retVal);
        file_put_contents($snapshotFile, $output);        
    }

    public static function RecreateSnapshots()
    {
        global $log;
        $log->logInfo('RecreateSnapshots - Resetting snapshots');
        $log->logInfo(passthru(SNAPSHOT_RESET_COMMAND));
        foreach (self::$fragments as $snapshot => $fragment)
        {
            $log->logInfo('RecreateSnapshots: ' . $fragment . '=>' . $snapshot);
            self::CreateSnapshot($fragment, SNAPSHOT_ROOT . $snapshot . '.html');
        }
    }

}

SnapshotService::Init();
require_once("teardown.php");
