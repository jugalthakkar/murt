<?php

require_once('DBConstants.php');

//Twitter Constants
if (!defined("CONSUMER_KEY")) {
    define("CONSUMER_KEY", "--");
}
if (!defined("CONSUMER_SECRET")) {
    define("CONSUMER_SECRET", "--");
}
if (!defined("USER_TOKEN")) {
    define("USER_TOKEN", "-----");
}

if (!defined("USER_SECRET")) {
    define("USER_SECRET", "--");
}

if (!defined("WEB_ROOT")) {
    define("WEB_ROOT", "http://localhost:8000/murt/");
}
if (!defined("PUBLISH_TWITTER")) {
    define("PUBLISH_TWITTER", true);
}

if (!defined("START_EXAM_ID")) {
    define("START_EXAM_ID", 3070);
}

?>