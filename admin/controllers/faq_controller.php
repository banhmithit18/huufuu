<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/faq.php');

$function = "";
//get function from ajax 
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

//function get faq
if ($function == "get_faq") {
    $db = new DBConnection();
    $sql = "SELECT * FROM faq ORDER BY faq_id DESC";
    $result = $db->Retrive($sql);
    echo json_encode($result);
    die();
}

//function add faq
if ($function == "add_faq") {
    $faq = new faq();
    //validate data
    $faq_question = $_POST['faq_question'] == null ? "" : $_POST['faq_question'];
    $faq_answer = $_POST['faq_answer'] == null ? "" : $_POST['faq_answer'];
    $faq_priority = $_POST['faq_priority'] == null ? 999 : $_POST['faq_priority'];
    $faq_status = $_POST['faq_status'] == null ? 0 : $_POST['faq_status'];

    //set data
    $faq->setFaqQuestion($faq_question);
    $faq->setFaqAnswer($faq_answer);
    $faq->setFaqpriority($faq_priority);
    $faq->setFaqStatus($faq_status);

    //insert data
    $db = new DBConnection();;
    try {
        $db->Create($faq);
        $log = new log();
        $log->SetLogName("Add faq");
        $log->SetLogDetail("Add faq question: " . $faq_question);
        $log->SetUserId($_SESSION['user_id']);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $log->SetLogTime($date);
        $db->Create($log);
    } catch (Exception $e) {
        $return_message = (array('status' => '0', 'response' => 'Error', 'error' => $e->getMessage()));
        echo json_encode($return_message);
        die();
    }

    $return_message = (array('status' => '1', 'response' => 'FAQ has been added', 'error' => '', 'faq_data' => $faq));
    echo json_encode($return_message);
    die();
}

//function update faq
if ($function == "update_faq") {
    $faq = new faq();
    //validate data
    $faq_id = $_POST['faq_id'] == null ? "" : $_POST['faq_id'];
    $faq_question = $_POST['faq_question'] == null ? "" : $_POST['faq_question'];
    $faq_answer = $_POST['faq_answer'] == null ? "" : $_POST['faq_answer'];
    $faq_priority = $_POST['faq_priority'] == null ? 999 : $_POST['faq_priority'];
    $faq_status = $_POST['faq_status'] == null ? 0 : $_POST['faq_status'];

    //set data
    $faq->setFaqQuestion($faq_question);
    $faq->setFaqAnswer($faq_answer);
    $faq->setFaqpriority($faq_priority);
    $faq->setFaqStatus($faq_status);

    //update data
    $db = new DBConnection();;
    if ($db->Update($faq, $faq_id)) {
        $log = new log();
        $log->SetLogName("Update faq");
        $log->SetLogDetail("Update faq with id: " . $faq_id);
        $log->SetUserId($_SESSION['user_id']);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $log->SetLogTime($date);
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'FAQ has been updated', 'error' => '', 'faq_data' => $faq));
        echo json_encode($return_message);
        die();
    } else {
        $return_message = (array('status' => '0', 'response' => 'Error', 'error' => $e->getMessage()));
        echo json_encode($return_message);
        die();
    }
}


//function delete faq
if ($function == "delete_faq") {
    $faq_id = $_POST['faq_id'] == null ? 0 : $_POST['faq_id'];
    $faq = new faq();
    $faq->faq_id = $faq_id;
    $db = new DBConnection();
    if ($db->Delete($faq)) {
        $log = new Log();
        $log->SetLogName("Delete faq");
        $log->SetLogDetail("Delete faq with id: " . $faq_id);
        $log->SetUserId($_SESSION['user_id']);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $log->SetLogTime($date);
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'FAQ has been deleted', 'error' => ''));
        echo json_encode($return_message);
        die();
    } else {
        $return_message = (array('status' => '0', 'response' => 'Error', 'error' => $e->getMessage()));
        echo json_encode($return_message);
        die();
    }
}
