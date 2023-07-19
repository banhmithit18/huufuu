<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');

$function = "";
//get function from ajax 
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

//function get media
if ($function == "get_media") {
    $db = new DBConnection();
    $sql = "SELECT * FROM media";
    $result = $db->Retrive($sql);
    echo json_encode($result);
    die();
}

//function update media
if ($function == "update_media") {
    $media_id = $_POST['media_id'] == null ? "" : $_POST['media_id'];
    $media_value = $_POST['media_value'] == null ? "" : $_POST['media_value'];
    $sql = "UPDATE media SET media_value = '$media_value'  WHERE media_id='$media_id'";
    //update data
    $db = new DBConnection();
    
    if ($db->Retrive($sql)) {
        $log = new log();
        $log->log_name = "Update media";
        $log->log_detail = "Update media with id: " . $media_id;
        $log->user_id = $_SESSION['user_id'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $log->log_time = $date;
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'Media has been updated', 'error' => ''));
        echo json_encode($return_message);
        die();
    } else {
        $return_message = (array('status' => '0', 'response' => 'Error', 'error' => $e->getMessage()));
        echo json_encode($return_message);
        die();
    }
}
?>
