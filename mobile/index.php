<?php
require_once("../includes/initialize.php");
require_once("../includes/exams.php");
require_once("../includes/PageSections.php");
$Maxcount=10;
if(isset($_GET['count'])) {
    $Maxcount=$_GET['count'];
}
spitPageHeader("Mobile");
?>
<table style="width: 470px;">
    <tr id="tHeader"><th>Exam Link</th><th style="width: 100px;">Discovery</th></tr>
    <?php
    $exams=exam::GetLatestResultsByCount($Maxcount);
    foreach($exams as $exam) {
        ?>
    <tr>
        <td><a href="<?php echo $exam->getURL(); ?>"><?php echo  $exam->ExamName; ?></a></td>
        <td class="timestamp"><?php echo  $exam->Discovered; ?></td>
    </tr>
        <?php } ?>
</table>
<a href="./">Refresh Now</a><br /><br />
<?php
spitPageFooter();
require_once("../includes/teardown.php");
?>
