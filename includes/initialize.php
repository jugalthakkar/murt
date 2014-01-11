<?php
ob_start();
require_once("constants.php");
//require_once("database.php");
require_once("rb.php");
//$database = new MySQLDatabase();
//$db =& $database;
date_default_timezone_set('Asia/Kolkata');
R::setup('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
//R::setup();
//R::debug();
?>