<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');

$PATH = '../../ultis/';
$content = "";
$function = "";
//receive data from ajax
if (isset($_POST['content'])) {
    $content = $_POST['content'];
}
//receive data from ajax 
if (isset($_POST['function'])) {
    $function = $_POST['function'];
}


//function get content from txt file
if ($function == "get_about_us") {
    //create file if not exist
    if (!file_exists($PATH . 'about_us.txt')) {
        $file = fopen($PATH . 'about_us.txt', 'w');
        fclose($file);
    }
    $file = fopen($PATH . "about_us.txt", "r");
    $content = fread($file, filesize($PATH . "about_us.txt"));
    fclose($file);
    echo json_encode($content);
    die();

}

//function save content to txt file
if ($function == "update_about_us") {
    try {
        $file = fopen($PATH . "about_us.txt", "w");
        $content = urldecode($content);
        fwrite($file, $content);
        fclose($file);
        WriteLog();
        $return_message = (array('status' => '1', 'response' => 'Content has been saved successfully', 'error' => ''));
        echo json_encode($return_message);
        die();
    } catch (Exception $e) {
        echo json_encode(array("status" => "0", "response" => "Content has not been saved successfully", "error" => $e->getMessage()));
        die();
    }
}

function WriteLog()
{
    //create log object
    $log = new log();
    $log->SetLogDetail("Edit about us content");
    $log->SetLogName("about_us");
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $log->SetLogTime(date("Y-m-d H:i:s"));
    $log->SetUserId($_SESSION['user_id']);
    //create database object
    $db = new DBConnection();
    $db->Create($log);
}

