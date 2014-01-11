<?php
require_once("includes/initialize.php");
require_once("includes/PageSections.php");
require_once("includes/exams.php");
$id=null;
if(isset($_GET["exam_id"]))
	$id=$_GET["exam_id"];
if($id==null){
	$id=exam::FindLastid();
}
$exam=exam::GetByID($id);
if($exam==null){
	$exam=new exam();
	$exam->Id=1;
	$exam->ExamName="Not Found";
}
spitPageHeader($exam->ExamName); ?>
<h3>Enter Exam Details</h3>
<form action="<?php echo WEB_ROOT; ?>showResult.php" method="post" >
    <table>
	<tr>
            <td>Exam</td>
            <td><?php echo $exam->ExamName; ?></td>
        </tr>
        <tr>
            <td>
                Year</td>
            <td>
                <input name="exam_year" type="text" /></td>
        </tr>
        <tr>
            <td>
                Month</td>
            <td>
                <select name="exam_month">
                    <option>January</option>
                    <option>February</option>
                    <option>March</option>
                    <option>April</option>
                    <option>May</option>
                    <option>June</option>
                    <option>July</option>
                    <option>August</option>
                    <option>September</option>
                    <option>October</option>
                    <option>November</option>
                    <option>December</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Seat Number</td>
            <td>
                <input name="seat_no" type="text" /></td>
        </tr>
        <tr>
            <td>
                <input  type="submit" value="submit" /></td>
            <td>
                <input  type="reset"  value="reset" /></td>
        </tr>
        <input type="hidden" name="exam_id" value="<?php echo $exam->Id; ?>" />

    </table>
</form>
<?php spitPageFooter(); ?>