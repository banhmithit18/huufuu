<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/contact_us.php');


$function = "";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}
if($function == "get_contact"){
    $db = new DBConnection();
    $sql = "SELECT service.service_id, service.service_name, 
    customer.customer_id,customer.customer_name,customer.customer_email, customer.customer_phone,
    contact_us_id, contact_us_messenger, contact_us_status, contact_us_created_time
    FROM `contact_us` 
    join `service` on service.service_id = contact_us.service_id
    join customer on contact_us.customer_id = customer.customer_id
    order by contact_us_status";
    $result = $db->Retrive($sql);
    echo json_encode($result);
    die();
}
if($function == 'handle_contact')
{
    $contact_us_id = $_REQUEST['contact_us_id'];
    $contact_us = new contact_us();
    $contact_us->contact_us_id = $contact_us_id;
    $db = new DBConnection();
    $sql =  "Update contact_us set contact_us_status = '1' where contact_us_id = $contact_us_id";
    if($db->Retrive($sql))
    {
        $log = new Log();
        $log->SetLogDetail("Handle contact id = $contact_us_id");
        $log->SetLogTime(date("Y-m-d H:i:s"));
        $log->SetUserId($_SESSION['user_id']);
        $log->SetLogName("Handle contact");
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'Order has been handled', 'error' => ''));
        echo json_encode($return_message);
        die();
    }
    else
    {
        $return_message = (array('status' => '0', 'response' => 'Cannot handle order, please try again', 'error' => 'Cannot handle order, please try again'));
        echo json_encode($return_message);
        die();
    }
}
?>