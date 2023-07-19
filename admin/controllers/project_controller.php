<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/project.php');

require_once('../models/image.php');

//get function from ajax
$function = "";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

//function get all project
if ($function == "get_project") {
    $sql = "SELECT * FROM project";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

if ($function == "get_image") {
    $project_id = $_REQUEST['project_id'] == "" ? 0 : $_REQUEST['project_id'];
    $sql = "SELECT * FROM project JOIN image ON project.image_id = image.image_id WHERE project_id = $project_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

if ($function == "save_project_edit") {
    $project_id = $_REQUEST['project_id'] == "" ? 0 : $_REQUEST['project_id'];
    $project_name = $_REQUEST['project_name'] == "" ? "" : $_REQUEST['project_name'];
    $project_content = $_REQUEST['project_content'] == "" ? "" : $_REQUEST['project_content'];
    $project_status = $_REQUEST['project_status'] == "" ? 0 : $_REQUEST['project_status'];
    $image_id = $_REQUEST['image_id'] == "" ? 0 : $_REQUEST['image_id'];

    //get old project
    $project = new project();
    $project->project_name = $project_name;
    $project->project_content = $project_content;
    $project->project_status = $project_status;
    $project->image_id = $image_id;

    $db = new DBConnection();
    if ($db->Update($project, $project_id)) {
        WriteLog("Update project", "Upadate project with id: $project_id");
        echo json_encode(array("status" => "1", "response" => "Project has not been updated successfully", "error" => ""));
    } else {
        echo json_encode(array("status" => "0", "response" => "Project has not been updated successfully", "error" => "Cannot update project, please try again !"));
    }
}

if ($function == "delete_project") {
    $project_id = $_REQUEST['project_id'] == "" ? 0 : $_REQUEST['project_id'];
    $project = new project();
    $project->project_id = $project_id;
    $db = new DBConnection();

    if ($db->Delete($project)) {
        WriteLog("Delete project", "Delete project with id: $project_id");
        echo json_encode(array("status" => "1", "response" => "Project has been deleted successfully", "error" => ""));
    } else {
        echo json_encode(array("status" => "0", "response" => "Project has not been deleted successfully", "error" => "Cannot delete project, please check if project has been used !"));
    }
}




if ($function == "save_image_edit") {
    $project_id = $_REQUEST['project_id'] == "" ? 0 : $_REQUEST['project_id'];
    $sql = "select * from image join project on image.image_id = project.image_id where project_id = $project_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    $image_id = 0;
    //get project
    $project = new project();
    $project->project_name = $result[0]['project_name'];
    $project->project_content = $result[0]['project_content'];
    $project->project_status = $result[0]['project_status'];

    //upload file to sv
    $file = $_FILES['project_image_0'];
    if ($file != null) {
        $return = UploadImage($file, $project_id);
        if ($return['status'] == "1") {
            $image_id = $return['image_id'];
            //set image id to updated one
            $project->image_id = $image_id;
        } else {
            echo json_encode(array("status" => "0", "response" => "Image has not been uploaded successfully", "error" => $return['error']));
            die();
        }
    }
    //update project
    if ($db->Update($project, $project_id)) {
        WriteLog("Update project", "Change project image with id: $project_id");
        echo json_encode(array("status" => "1", "response" => "Project has not been updated successfully", "error" => ""));
    } else {
        echo json_encode(array("status" => "0", "response" => "Project has not been updated successfully", "error" => "Cannot update project, please try again !"));
    }
}

if ($function == "add_project") {
    ob_start();
    //get data from ajax
    $project_name = $_POST['project_name'] == null ? "" : $_POST['project_name'];
    $project_content = $_POST['project_content'] == null ? 0 : $_POST['project_content'];
    $project_status = $_POST['project_status'] == null ? 0 : $_POST['project_status'];
    $image_id = 0;

    //create project ent
    $project = new project();
    $project->project_name = $project_name;
    $project->project_content = $project_content;
    $project->project_status = $project_status;
    //get lastId project id
    $db = new DBConnection();
    $lastId =  $db->GetLastId("project") + 1;
    //add image then get inserted id 
    $file = $_FILES['project_image_0'];
    if ($file != null) {
        $return = UploadImage($file, $lastId, true);
        if ($return['status'] == "1") {
            $image_id =  $return['image_id'];
            //create project
            $project->image_id = $image_id;

            if ($db->Create($project)) {
                WriteLog("Add project", "Add project with project_id = " . $lastId);
                echo json_encode(array("status" => "1", "response" => "Project has been added successfully"));
            } else {
                //rollback image if create failed
                $image = new image();
                $image->image_id = $image_id;
                //delete project
                $db->Delete($image);
                ob_end_clean();
                echo json_encode(array("status" => "0", "response" => "Project has not been saved successfully", "error" => $e->getMessage()));
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

function UploadImage($imgae, $project_id)
{
    $image_path = "../../img/project/";
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
            $time_stamp = $file_name . time() . $project_id;
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