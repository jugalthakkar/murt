<?php
require_once("includes/TwitterWrapper.php");
require_once 'includes/exams.php';
$status="http://results.mu.ac.in/choose_nob.php?exam_id=9999 ";
$status.="http://results.mu.ac.in/choose_nob.php?exam_id=9999 ";
$status.="http://results.mu.ac.in/choose_nob.php?exam_id=9999 ";
$status.="http://results.mu.ac.in/choose_nob.php?exam_id=9999 ";
$status.="http://results.mu.ac.in/choose_nob.php?exam_id=9999 ";
$status.="http://results.mu.ac.in/choose_nob.php?exam_id=9999 ";
$exam=new exam();
$exam->Id=1253;
$exam->ExamName="S.Y.B.Sc. I.T. (Sem.-IV) Supplementary Exam) (IDOL)";
$exam->tweetMe();
//TwitterWrapper::tweet($status);

?>