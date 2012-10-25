<?php
require_once("../includes/initialize.php");
require_once("../includes/exams.php");
require_once("../includes/PageSections.php");
$Maxcount=10;
if(isset($_GET['count'])) {
    $Maxcount=$_GET['count'];
}
spitPageHeader("HTML"); ?>

<div id="mainCont">    
    <table style="width: 450px;">
        <caption id='tCaption'></caption>
        <tbody>
            <tr id="tHeader"><th>Exam Link</th><th style="width: 100px;">Discovery</th></tr>
            <?php
            $exams=exam::GetLatestResultsByCount($Maxcount);
            foreach($exams as $exam) {
                ?>
            <tr class="examRow" >
                <td id="<?php echo $exam->Id; ?>"><a href="<?php echo $exam->getURL(); ?>"><?php echo  $exam->ExamName; ?></a></td>
                <td class="timestamp"><?php echo  ($exam->Discovered); ?></td>
            </tr>
                <?php
            }

            ?>
        </tbody>
    </table>
</div>
<?php include_once('javascript.php'); ?>
<?php spitPageFooter(); ?>

<?php
ob_end_flush();
$database->close_connection();
?>