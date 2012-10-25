<?php
ob_start();
require_once("constants.php");
require_once("database.php");
$database = new MySQLDatabase();
$db =& $database;
date_default_timezone_set('Asia/Kolkata');
?>