<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../ultis/DBConnection.php');
require_once('../admin/models/customer.php');
require_once('../admin/models/contact_us.php');
require_once('../admin/models/contact_answer.php');


$_SESSION['questions'] = null;
getQuestion();

//get function from ajax
$function = "";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'] == null ? "" : $_REQUEST['function'];
}

function getQuestion(){
    $sql = "SELECT * FROM contact_question WHERE contact_question_status = '1 ' ORDER BY contact_question_priority";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    $_SESSION['questions'] = $result;
}

//function get all project
if ($function == "create_contact") {
    $customer_name = $_REQUEST['customer_name'];
    $customer_mail = $_REQUEST['customer_mail'];
    $customer_phone = $_REQUEST['customer_phone'];
    $answers = $_REQUEST['answers'];
    //check exist
    
    $result = checkExistedCustomer($customer_name,$customer_mail,$customer_phone);
    if($result != null){
        //if not null then get id
        $customer_id = $result[0]['customer_id'];
         //create contact
         if(createContact($customer_id,$answers)){
            echo json_encode(array("status" => "1", "response" => "Your message has been sent", "error" => "Your message has been sent"));
            die();
        }else{
            echo json_encode(array("status" => "0", "response" => "Failed to send message", "error" => "Failed to send message"));
            die();
        }
    }else{
        //if null then create
        $customer_id = createCustomer($customer_name,$customer_mail,$customer_phone);
        //check if create successfully or not
        if($customer_id == 0){
            echo json_encode(array("status" => "0", "response" => "Failed to send message", "error" => "Failed to send message"));
            die();
        }else{
            //create contact
            if(createContact($customer_id,$answers)){
                echo json_encode(array("status" => "1", "response" => "Your message has been sent", "error" => "Your message has been sent"));
                die();
            }else{
                echo json_encode(array("status" => "0", "response" => "Failed to send message", "error" => "Failed to send message"));
                die();
            }
        }
    }
}

function checkExistedCustomer($name,$mail,$phone){
    $sql = "SELECT * FROM customer WHERE customer_name = '$name' AND customer_email = '$mail' AND customer_phone = '$phone'";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    return $result;
}

function createCustomer($name, $mail, $phone){
    $customer = new customer();
    $customer->SetCustomerAddress("");
    $customer->SetCustomerAge(null);
    $customer->SetCustomerEmail($mail);
    $customer->SetCustomerGender("3");
    $customer->SetCustomerName($name);
    $customer->SetCustomerPhone($phone);

    $db = new DBConnection();
    $customer_id = 0;
    if( $db->Create($customer)){
        $customer_id = $db->GetLastId("customer");
    }
    return $customer_id;
}

function createContact($customer_id,$answers){
    $contact_us = new contact_us();
    $contact_us->SetCustomerId($customer_id);
    $contact_us->SetContactUsStatus(0);
    
    $db = new DBConnection();
    if( $db->Create($contact_us)){
        $contact_us_id = $db->GetLastId("contact_us");
        foreach($answers as $key => $value) {
            if( insertContactAnswer($contact_us_id,$key,$value) == false){
                return false;
            }
        }

        return true;
    }
    return false;
    
}

function insertContactAnswer($contact_us_id, $question_id, $answer_content){
    $answer = new contact_answer();
    $answer -> setContactQuestionId($question_id);
    $answer -> setContactAnswerContent($answer_content);
    $answer -> setContactUsId($contact_us_id);
    $db = new DBConnection();
    if( $db->Create($answer)){
        return true;
    }else{
        return false;
    }
}



