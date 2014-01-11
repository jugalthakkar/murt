<?php
require_once("includes/initialize.php");
require_once("includes/exams.php");
require_once("includes/PageSections.php");
$newarr=array();
foreach($_POST as $key=>$value) {
    $newarr[$key]=$value;
}
$newarr['exam_month']=strtoupper(substr($newarr['exam_month'],0,3));
$result=exam::getResult($newarr);
$title="Result for seat #" . $newarr['seat_no'];
spitPageHeader($title); ?>
<h3>Result for seat # <strong><?php echo $newarr['seat_no']; ?></strong></h3>
<p class="highlight-3">

    <?php
    if(trim($result)=='') {
        echo "Error in input, please try again<br />";
        echo "<a href=\"ExamDetails.php?exam_id=" . $newarr['exam_id'] . "\">Back</a>";
    }else {
        echo $result;
    }
    ?>
</p>
<?php spitPageFooter();
require_once './includes/teardown.php';
?>