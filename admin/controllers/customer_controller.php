<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/customer.php');
$function = "";

//get function from ajax 
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

//function get customer from database
if ($function == "get_customer") {
    $db = new DBConnection();
    $sql = "SELECT * FROM customer ORDER BY customer_id desc";
    $result = $db->Retrive($sql);
    echo json_encode($result);
    die();
}



//function delete customer from database
if ($function == "delete_customer") {
    $customer_id = $_REQUEST['customer_id'];
    $customer = new customer();
    $customer->customer_id = $customer_id;
    $db = new DBConnection();
    if ($result = $db->Delete($customer)) {
        $log = new Log();
        $log->GetLogDetail("Delete customer with id = $customer_id");
        $log->SetLogTime(date("Y-m-d H:i:s"));
        $log->SetUserId($_SESSION['user_id']);
        $log->SetLogName("Delete customer");
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'Customer has been deleted !', 'error' => ''));
        echo json_encode($return_message);
        die();
    } else {
        $return_message = (array('status' => '0', 'response' => 'Cannot delete customer', 'error' => 'Cannot delete customer, please check if customer has any reivew or order'));
        echo json_encode($return_message);
        die();
    }
}

//function add customer to database
if ($function == "add_customer") {
    $customer = new customer();
    //validate
    $customer_address = $_POST['customer_address'] == null ? "" : $_POST['customer_address'];
    $customer_phone = $_POST['customer_phone'] == null ? "" : $_POST['customer_phone'];
    $customer_email = $_POST['customer_email'] == null ? "" : $_POST['customer_email'];
    $customer_age = $_POST['customer_age'] == null ? "" : $_POST['customer_age'];
    $customer_gender = $_POST['customer_gender'] == null ? 0 : $_POST['customer_gender'];
    $customer_name = $_POST['customer_name'] == null ? "" : $_POST['customer_name'];

    //create entity
    $customer->SetCustomerAddress($customer_address);
    $customer->SetCustomerAge($customer_age);
    $customer->SetCustomerEmail($customer_email);
    $customer->SetCustomerGender($customer_gender);
    $customer->SetCustomerName($customer_name);
    $customer->SetCustomerPhone($customer_phone);
    //insert
    $db = new DBConnection();;
    try {
        $db->Create($customer);
        $log = new Log();
        $log->SetLogName("Add customer");
        $log->SetLogDetail("Add customer $customer_name");
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

    $return_message = (array('status' => '1', 'response' => 'Customer has been added', 'error' => '', 'customer_data' => $customer));
    echo json_encode($return_message);
    die();
}

//function update customer to database
if ($function == "update_customer") {
    $customer = new customer();
    //validate
    $customer_id = $_POST['customer_id'] == null ? 0 : $_POST['customer_id'];
    $customer_address = $_POST['customer_address'] == null ? "" : $_POST['customer_address'];
    $customer_phone = $_POST['customer_phone'] == null ? "" : $_POST['customer_phone'];
    $customer_email = $_POST['customer_email'] == null ? "" : $_POST['customer_email'];
    $customer_age = $_POST['customer_age'] == null ? "" : $_POST['customer_age'];
    $customer_gender = $_POST['customer_gender'] == null ? 0 : $_POST['customer_gender'];
    $customer_name = $_POST['customer_name'] == null ? "" : $_POST['customer_name'];
    
    //create ent
    $customer->SetCustomerAddress($customer_address);
    $customer->SetCustomerAge($customer_age);
    $customer->SetCustomerEmail($customer_email);
    $customer->SetCustomerGender($customer_gender);
    $customer->SetCustomerName($customer_name);
    $customer->SetCustomerPhone($customer_phone);

    //update
    $db = new DBConnection();;
    if ($db->Update($customer, $customer_id)) {
        $log = new Log();
        $log->SetLogName("Update customer");
        $log->SetLogDetail("Update customer with id= $customer_id");
        $log->SetUserId($_SESSION['user_id']);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $log->SetLogTime($date);
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'Customer has been updated', 'error' => ''));
        echo json_encode($return_message);
        die();
    }
    die();
}
