<?php
require_once("../includes/initialize.php");
require_once("../includes/exams.php");
header('Content-type: application/rss+xml');
//exam::updateOnline();
echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
echo '<channel>';
echo '<atom:link href="'.WEB_ROOT.'rss/" rel="self" type="application/rss+xml" />';
echo '<title>Mumbai University Result Tracker</title>';
echo '<link>'.WEB_ROOT.'</link>';
echo '<description>Mumbai University Result Tracker by Jugal Thakkar</description>';
$exams=exam::GetLatestResultsByCount(10);
foreach($exams as $exam) {
    echo '<item>';
    echo '<title>' . htmlspecialchars($exam->ExamName) . '</title>';
    echo '<link>' . $exam->getURL() . '</link>';
    echo '<description>' . htmlentities($exam->ExamName) . '</description>';
    echo '<pubDate>' . date("r",$exam->Discovered) . '</pubDate>';
    echo '<guid>' . $exam->getURL() . '</guid>';
    echo '</item>';
}
echo '</channel>';
echo '</rss>';
?>