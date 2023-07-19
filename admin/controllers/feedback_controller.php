<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/feedback.php');

require_once('../models/image.php');

//get function from ajax
$function = "";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

//function get all feedback
if ($function == "get_feedback") {
    $sql = "SELECT * FROM feedback";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

if ($function == "get_image") {
    $feedback_id = $_REQUEST['feedback_id'] == "" ? 0 : $_REQUEST['feedback_id'];
    $sql = "SELECT * FROM feedback JOIN image ON feedback.image_id = image.image_id WHERE feedback_id = $feedback_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

if ($function == "save_feedback_edit") {
    $feedback_id = $_REQUEST['feedback_id'] == "" ? 0 : $_REQUEST['feedback_id'];
    $feedback_name = $_REQUEST['feedback_name'] == "" ? "" : $_REQUEST['feedback_name'];
    $feedback_content = $_REQUEST['feedback_content'] == "" ? "" : $_REQUEST['feedback_content'];
    $feedback_status = $_REQUEST['feedback_status'] == "" ? 0 : $_REQUEST['feedback_status'];
    $image_id = $_REQUEST['image_id'] == "" ? 0 : $_REQUEST['image_id'];

    //get old feedback
    $feedback = new feedback();
    $feedback->feedback_name = $feedback_name;
    $feedback->feedback_content = $feedback_content;
    $feedback->feedback_status = $feedback_status;
    $feedback->image_id = $image_id;

    $db = new DBConnection();
    if ($db->Update($feedback, $feedback_id)) {
        WriteLog("Update feedback", "Upadate feedback with id: $feedback_id");
        echo json_encode(array("status" => "1", "response" => "Feedback has not been updated successfully", "error" => ""));
    } else {
        echo json_encode(array("status" => "0", "response" => "Feedback has not been updated successfully", "error" => "Cannot update feedback, please try again !"));
    }
}

if ($function == "delete_feedback") {
    $feedback_id = $_REQUEST['feedback_id'] == "" ? 0 : $_REQUEST['feedback_id'];
    $feedback = new feedback();
    $feedback->feedback_id = $feedback_id;
    $db = new DBConnection();

    if ($db->Delete($feedback)) {
        WriteLog("Delete feedback", "Delete feedback with id: $feedback_id");
        echo json_encode(array("status" => "1", "response" => "Feedback has been deleted successfully", "error" => ""));
    } else {
        echo json_encode(array("status" => "0", "response" => "Feedback has not been deleted successfully", "error" => "Cannot delete feedback, please check if feedback has been used !"));
    }
}




if ($function == "save_image_edit") {
    $feedback_id = $_REQUEST['feedback_id'] == "" ? 0 : $_REQUEST['feedback_id'];
    $sql = "select * from image join feedback on image.image_id = feedback.image_id where feedback_id = $feedback_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    $image_id = 0;
    //get feedback
    $feedback = new feedback();
    $feedback->feedback_name = $result[0]['feedback_name'];
    $feedback->feedback_content = $result[0]['feedback_content'];
    $feedback->feedback_status = $result[0]['feedback_status'];

    //upload file to sv
    $file = $_FILES['feedback_image_0'];
    if ($file != null) {
        $return = UploadImage($file, $feedback_id);
        if ($return['status'] == "1") {
            $image_id = $return['image_id'];
            //set image id to updated one
            $feedback->image_id = $image_id;
        } else {
            echo json_encode(array("status" => "0", "response" => "Image has not been uploaded successfully", "error" => $return['error']));
            die();
        }
    }
    //update feedback
    if ($db->Update($feedback, $feedback_id)) {
        WriteLog("Update feedback", "Change feedback image with id: $feedback_id");
        echo json_encode(array("status" => "1", "response" => "Feedback has not been updated successfully", "error" => ""));
    } else {
        echo json_encode(array("status" => "0", "response" => "Feedback has not been updated successfully", "error" => "Cannot update feedback, please try again !"));
    }
}

if ($function == "add_feedback") {
    ob_start();
    //get data from ajax
    $feedback_name = $_POST['feedback_name'] == null ? "" : $_POST['feedback_name'];
    $feedback_content = $_POST['feedback_content'] == null ? 0 : $_POST['feedback_content'];
    $feedback_status = $_POST['feedback_status'] == null ? 0 : $_POST['feedback_status'];
    $image_id = 0;

    //create feedback ent
    $feedback = new feedback();
    $feedback->feedback_name = $feedback_name;
    $feedback->feedback_content = $feedback_content;
    $feedback->feedback_status = $feedback_status;
    //get lastId feedback id
    $db = new DBConnection();
    $lastId =  $db->GetLastId("feedback") + 1;
    //add image then get inserted id 
    $file = $_FILES['feedback_image_0'];
    if ($file != null) {
        $return = UploadImage($file, $lastId, true);
        if ($return['status'] == "1") {
            $image_id =  $return['image_id'];
            //create feedback
            $feedback->image_id = $image_id;

            if ($db->Create($feedback)) {
                WriteLog("Add feedback", "Add feedback with feedback_id = " . $lastId);
                echo json_encode(array("status" => "1", "response" => "Feedback has been added successfully"));
            } else {
                //rollback image if create failed
                $image = new image();
                $image->image_id = $image_id;
                //delete feedback
                $db->Delete($image);
                ob_end_clean();
                echo json_encode(array("status" => "0", "response" => "Feedback has not been saved successfully", "error" => $e->getMessage()));
            }
        } else {
            echo json_encode(array("status" => "0", "response" => "Image has not been uploaded successfully", "error" => $return['error']));
            die();
        }
    }else{
        ob_end_clean();
        echo json_encode(array("status" => "0", "response" => "Could not find image file", "error" => $e->getMessage()));
    }
}

function UploadImage($imgae, $feedback_id)
{
    $image_path = "../../img/feedback/";
    $file = $imgae;
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_error = $file['error'];
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));
    $allowed = array('jpg', 'jpeg', 'png');
    if (in_array($file_ext, $allowed)) {
        if ($file_error === 0) {
            //genarate time stamp with blog id
            $time_stamp = $file_name . time() . $feedback_id;
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

function WriteLog($log_name, $log_detail)
{
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
