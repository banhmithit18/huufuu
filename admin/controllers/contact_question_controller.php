<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/contact_question.php');

$function = "";
//get function from ajax 
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

//function get question
if ($function == "get_contact_question") {
    $db = new DBConnection();
    $sql = "SELECT * FROM contact_question ORDER BY contact_question_id DESC";
    $result = $db->Retrive($sql);
    echo json_encode($result);
    die();
}

//function add contact question
if ($function == "add_contact_question") {
    $cq = new contact_question();
    //validate data
    $contact_question_content = $_POST['contact_question_content'] == null ? "" : $_POST['contact_question_content'];
    $contact_question_priority = $_POST['contact_question_priority'] == null ? 999 : $_POST['contact_question_priority'];
    $contact_question_status = $_POST['contact_question_status'] == null ? 0 : $_POST['contact_question_status'];
    $contact_question_required = $_POST['contact_question_required'] == null ? 0 : $_POST['contact_question_required'];


    //set data
    $cq->setContactQuestionContent($contact_question_content);
    $cq->setContactQuestionPriority($contact_question_priority);
    $cq->setContactQuestionStatus($contact_question_status);
    $cq->setContractQuestionRequired($contact_question_required);

    //insert data
    $db = new DBConnection();;
    try {
        $db->Create($cq);
        $log = new log();
        $log->SetLogName("Add contact question");
        $log->SetLogDetail("Add contact question: " . $contact_question_content);
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

    $return_message = (array('status' => '1', 'response' => 'Contact Question has been added', 'error' => '', 'contact_question_data' => $cq));
    echo json_encode($return_message);
    die();
}

//function update contact question
if ($function == "update_contact_question") {
    $cq = new contact_question();
    //validate data
    $contact_question_id = $_POST['contact_question_id'] == null ? "" : $_POST['contact_question_id'];
    $contact_question_content = $_POST['contact_question_content'] == null ? "" : $_POST['contact_question_content'];
    $contact_question_priority = $_POST['contact_question_priority'] == null ? 0 : $_POST['contact_question_priority'];
    $contact_question_status = $_POST['contact_question_status'] == null ? 0 : $_POST['contact_question_status'];
    $contact_question_required = $_POST['contact_question_required'] == null ? 0 : $_POST['contact_question_required'];

    //set data
    $cq->setContactQuestionContent($contact_question_content);
    $cq->setContactQuestionPriority($contact_question_priority);
    $cq->setContactQuestionStatus($contact_question_status);
    $cq->setContractQuestionRequired($contact_question_required);

    //update data
    $db = new DBConnection();;
    if ($db->Update($cq, $contact_question_id)) {
        $log = new log();
        $log->SetLogName("Update contact question");
        $log->SetLogDetail("Update contact question with id: " . $contact_question_id);
        $log->SetUserId($_SESSION['user_id']);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $log->SetLogTime($date);
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'Contract Question has been updated', 'error' => '', 'contact_question_data' => $cq));
        echo json_encode($return_message);
        die();
    } else {
        $return_message = (array('status' => '0', 'response' => 'Error', 'error' => $e->getMessage()));
        echo json_encode($return_message);
        die();
    }
}

