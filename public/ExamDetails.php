<?php
require_once("../includes/initialize.php");
require_once("../includes/exams.php");
$id = null;
if (isset($_GET["exam_id"])) $id = $_GET["exam_id"];
if ($id == null)
{
    $id = exam::FindLastid();
}
$exam = exam::GetByID($id);
if ($exam == null)
{
    $exam = new exam();
    $exam->Id = 1;
    $exam->ExamName = "Not Found";
}
header("Location: " . WEB_ROOT . "#!/result/" . $exam->Id . "/" . $exam->ExamName, TRUE, 301);
require_once("../includes/teardown.php");
