<?php
require_once("initialize.php");
require_once("exams.php");
exam::updateOnline();
echo "Updated: " .  date('l jS \of F Y h:i:s A');
?>