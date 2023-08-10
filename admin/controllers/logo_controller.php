<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/image.php');

$function = "";
//get function from ajax 
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

//function get logo
if ($function == "get_logo") {
    $db = new DBConnection();
    $sql = "SELECT logo.*, image.image_path FROM logo JOIN image ON image.image_id = logo.image_id WHERE image.image_status = '1'";
    $result = $db->Retrive($sql);
    echo json_encode($result);
    die();
}


//get file from ajax and save to server and return path
function UploadImage($imgae, $logo_id)
{
    $image_path = "../../img/logo/";
    $file = $imgae;
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_error = $file['error'];
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));
    $allowed = array('jpg', 'jpeg', 'png','svg');
    if (in_array($file_ext, $allowed)) {
        if ($file_error === 0) {
            //genarate time stamp with logo id
            $time_stamp = time() . $logo_id;
            $file_name_new = $time_stamp . "." . $file_ext;
            $file_destination = $image_path . $file_name_new;
            move_uploaded_file($file_tmp, $file_destination);
            $path = $file_destination;
            return array("image_id" => CreateImage($path), "status" => "1", "error" => "");
        } else {
            return array("image_id" => "", "status" => "0", "error" => "There was an error uploading your file");
        }
    } else {
        return array("image_id" => "", "status" => "0", "error" => "You cannot upload files of this type");
    }
}


//function update image
if ($function == "update_image") {

    $image = $_FILES['image'] == null ? "" : $_FILES['image'];
    $image_id = $_POST['image_id'];
    $db = new DBConnection();
    //check sql injection
    $sql = "SELECT * FROM logo JOIN IMAGE ON logo.image_id = image.image_id WHERE logo.image_id =" . $image_id;
    $ib = $db->Retrive($sql);
    //create image
    $image = UploadImage($image, $ib[0]['logo_id']);
    $image_id = $image['image_id'];
    $sql = "UPDATE logo SET image_id = '$image_id' WHERE logo_id = '".$ib[0]['logo_id']."'";
    //update logo
    if ($db->Retrive($sql)) {
        WriteLog("Update logo'thumb", "Update logo's image (logo id = " . $ib[0]['logo_id'] . ") with image id = " . $image_id);
        $return_message = (array('status' => '1', 'response' => 'Image has been updated successfully', 'error' => ''));
        echo json_encode($return_message);
        die();
    } else {
        $return_message = (array('status' => '0', 'response' => 'Image has not been updated successfully', 'error' => 'Image has not been updated successfully'));
        echo json_encode($return_message);
        die();
    }
}

//function create image
function CreateImage($image_path)
{
    $image = new Image();
    $image->SetImagePath($image_path);
    $image->SetImageStatus(1);
    $db = new DBConnection();
    $db->Create($image);
    $image_id = $db->GetLastId("image");
    return $image_id;
}

//write log
function WriteLog($log_name,$log_detail){
    //create log object
    $log = new log();
    $log->SetLogDetail($log_detail);
    $log->SetLogName($log_name);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $log->SetLogTime(date("Y-m-d H:i:s"));
    $log->SetUserId($_SESSION['user_id']);
    //create database object
    $db = new DBConnection();
    $db->Create($log);
}


?>
