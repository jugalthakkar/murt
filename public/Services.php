<?php
if (isset($_GET['s']))
{
    $service = $_GET['s'];
    if ($service == 'get')
    {
        require_once("../includes/initialize.php");
        require_once("../includes/exams.php");
        $exams;
        $count = 0;
        $startId = 0;
        if (isset($_GET['count'])) $count = ($_GET['count']);
        if (isset($_GET['after'])) $startId = $_GET['after'];
        if ($count > 0 && $startId > 0)
        {
            $exams = exam::GetLatestResultsAfterIdByCount($startId, $count);
        }
        elseif ($count > 0)
        {
            $exams = exam::GetLatestResultsByCount($count);
        }
        elseif ($startId > 0)
        {
            $exams = exam::GetLatestResultsAfterId($startId);
        }
        else
        {
            $exams = exam::GetAll();
        }
        //header('Content-type: application/json');
        echo json_encode($exams);
        require_once("../includes/teardown.php");
    }
    else if ($service == 'result')
    {
        require_once("../includes/initialize.php");
        require_once("../includes/exams.php");
        $newarr = array();
        foreach ($_GET as $key => $value)
        {
            $newarr[$key] = $value;
        }
        $newarr['exam_month'] = strtoupper(substr($newarr['exam_month'], 0, 3));
        $result = exam::getResult($newarr);
        if (trim($result) == '')
        {
            $response = array("result" => "Unavailable");
        }
        else
        {
            $response = array("result" => $result);
        }

        echo json_encode($response);
        require_once("../includes/teardown.php");
    }
    else if ($service == 'update')
    {
        require_once("../includes/initialize.php");
        require_once("../includes/exams.php");
        exam::updateOnline();
        echo "Updated: " . date('l jS \of F Y h:i:s A');
        require_once("../includes/teardown.php");
    }
    else if ($service == 'getExam')
    {
        require_once("../includes/initialize.php");
        require_once("../includes/exams.php");
        $id = isset($_GET['id']) ? $_GET['id'] : EXAM_ID_PLACEHOLDER;
        $exam;
        if ($id == EXAM_ID_PLACEHOLDER)
        {
            $exam = new exam();
            $exam->ExamName = EXAM_NAME_PLACEHOLDER;
            $exam->Id = $id;
            $exam->Discovered = 0;
        }
        else
        {
            $exam = exam::GetByID($_GET['id']);
        }

        echo json_encode($exam);
        require_once("../includes/teardown.php");
    }
//    else if ($service == 'updateSnapshot')
//    {
//        require_once("../includes/SnapshotService.php");
//        SnapshotService::RecreateSnapshots();
//        echo "Updated: " . date('l jS \of F Y h:i:s A');
//        require_once("../includes/teardown.php");
//    }
//    else if ($service == 'getSnapshot')
//    {
//        require_once("../includes/SnapshotService.php");
//        echo SnapshotService::GetSnapshot($_GET['_escaped_fragment_']);
//        require_once("../includes/teardown.php");
//    }
}

?>