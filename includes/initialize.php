<?php
ob_start();
require_once("constants.php");
require_once("rb.php");
require_once("KLogger.php");
date_default_timezone_set(DEFAULT_TIME_ZONE);
$log = KLogger::instance(LOG_PATH, KLogger::DEBUG);
function unhandled_exception_handler($exception)
{
    global $log;
    $log->logFatal("Uncaught exception: " . $exception->getMessage(), $exception);
}
set_exception_handler('unhandled_exception_handler');
R::setup('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
//R::setup();
//R::debug();

?>