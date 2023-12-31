<?php
define("IMAGE_WIDTH", 400);
define("IMAGE_HEIGHT", 400);

session_start();
$PATH = '../../img/project_detail/';

require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/project.php');
require_once('../models/image.php');
require_once('../models/project_detail.php');

//get function from ajax
$function = "";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

if ($function == 'get_last_project_detail_priority') {
    $project_id = $_REQUEST['project_id'];
    $sql = "SELECT project_detail_priority FROM project_detail WHERE project_id = '$project_id' ORDER BY project_detail_priority DESC";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    if ($result != '') {
        echo $result[0]['project_detail_priority'];
    } else {
        echo 1;
    }
}

//function save project_detail
if ($function == 'add_project_detail') {
    //get data from ajax
    $project_id = $_REQUEST['project_id'];
    $text = $_REQUEST['project_detail_text'];
    $type = $_REQUEST['project_detail_type'];
    $priority =  $_REQUEST['project_detail_priority'];
    $isActive =  $_REQUEST['project_detail_status'];
    $isSameRow =  $_REQUEST['project_detail_isSameRow'];

    //step 1 : add detail
    $project_detail = new project_detail();
    $project_detail->setProjectId($project_id);
    $project_detail->setProjectDetailType($type);
    $project_detail->setProjectDetailText($text);
    $project_detail->setProjectDetailPriority($priority);
    $project_detail->setProjectDetailStatus($isActive);
    $project_detail->setProjectDetailIsSameRow($isSameRow);
    $project_detail->setImageId(null);
    $project_detail_id = 0;

    $db = new DBConnection();
    if ($db->Create($project_detail)) {
        //check if type = 1 = iamge
        if ($type == "1") {
            $project_detail->setProjectDetailText("");
            //get last id detail
            $project_detail_id = $db->GetLastId("project_detail");
            $image_id = null;
            //step 2 : add image service
            //get file
            $file = $_FILES['project_detail_image'];
            if ($file != null) {
                $return = UploadImage($file, $project_detail_id, false);
                if ($return['status'] == "1") {
                    $image_id =  $return['image_id'];
                }
            } else {
                $project_detail = new project_detail();
                $project_detail->project_detail_id = $project_detail_id;
                //delete service
                $db->Delete($project_detail);
                echo json_encode(array("status" => "0", "response" => "Image has not been uploaded successfully", "error" => $return['error']));
                die();
            }
            $project_detail->setImageId($image_id);
            $db->Update($project_detail, $project_detail_id);
        }
        //uppdate project
        $sql = "SELECT * FROM project WHERE project_id = $project_id";
        $db = new DBConnection();
        $result = $db->Retrive($sql);
        //get project
        $project = new project();
        $project->project_name = $result[0]['project_name'];
        $project->project_content = $result[0]['project_content'];
        $project->project_status = $result[0]['project_status'];
        $project->image_id = $result[0]['image_id'];
        $project->background_image_id = $result[0]['background_image_id'];
        $project->category_id = $result[0]['category_id'];
        $project->hasDetail = 1;
        $db->Update($project, $project_id);

        WriteLog("Add project detail", "add project detail with id = " . $project_detail_id);
        echo json_encode(array("status" => "1", "response" => "Project detail has been added successfully"));
    } else {
        echo json_encode(array("status" => "0", "response" => "Project detail has not been saved successfully", "error" => $e->getMessage()));
    }
}

//delete
if ($function == "delete_project_detail") {
    ob_start();
    //get data from ajax
    $project_detail_id = $_REQUEST['project_detail_id'] == "" ? 0 : $_REQUEST['project_detail_id'];
    $project_detail = new project_detail();
    $project_detail->project_detail_id = $project_detail_id;
    $db = new DBConnection();
    if ($db->Delete($project_detail)) {
        WriteLog("Delete project detail", "Deleted project detail with project_detail_id = " . $project_detail_id);
        ob_end_clean();
        echo json_encode(array("status" => "1", "response" => "Project detail has been deleted successfully"));
    } else {
        echo json_encode(array("status" => "0", "response" => "Project detail has not been deleted", "error" => $e->getMessage()));
    }
}

if ($function == "save_project_detail_text_edit") {
    $project_detail_id = $_REQUEST['project_detail_id'] == "" ? 0 : $_REQUEST['project_detail_id'];
    $project_detail_text_edit = $_REQUEST['project_detail_text'] == "" ? "" : $_REQUEST['project_detail_text'];

    //get old data 
    $sql = "SELECT * FROM project_detail WHERE project_detail_id = $project_detail_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);

    $project_detail = new project_detail;
    $project_detail->setProjectId($result[0]['project_id']);
    $project_detail->setProjectDetailType($result[0]['project_detail_type']);
    $project_detail->setProjectDetailText($project_detail_text_edit);
    $project_detail->setImageId($result[0]['image_id']);
    $project_detail->setProjectDetailPriority($result[0]['project_detail_priority']);
    $project_detail->setProjectDetailStatus($result[0]['project_detail_status']);
    $project_detail->setProjectDetailIsSameRow($result[0]['project_detail_isSameRow']);

    //update project
    if ($db->Update($project_detail, $project_detail_id)) {
        WriteLog("Update project detail text ", "Change project text with id: $project_detail_id");
        echo json_encode(array("status" => "1", "response" => "Project detail has been updated successfully", "error" => ""));
    } else {
        echo json_encode(array("status" => "0", "response" => "Project detail has not been updated successfully", "error" => "Cannot update project, please try again !"));
    }
}

if ($function == "save_image_detail_edit") {
    $project_detail_id = $_REQUEST['project_detail_id'] == "" ? 0 : $_REQUEST['project_detail_id'];
    //get old data 
    $sql = "SELECT * FROM project_detail WHERE project_detail_id = $project_detail_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);

    $project_detail = new project_detail;
    $project_detail->setProjectId($result[0]['project_id']);
    $project_detail->setProjectDetailType($result[0]['project_detail_type']);
    $project_detail->setProjectDetailText($result[0]['project_detail_text']);
    $project_detail->setProjectDetailPriority($result[0]['project_detail_priority']);
    $project_detail->setProjectDetailStatus($result[0]['project_detail_status']);
    $project_detail->setProjectDetailIsSameRow($result[0]['project_detail_isSameRow']);

    $image_id = 0;
    //upload file to sv
    $file = null;
    if (isset($_FILES['project_detail_image'])) {
        $file = $_FILES['project_detail_image'];
    }
    if ($file != null) {
        $return = UploadImage($file, $project_detail_id, false);
        if ($return['status'] == "1") {
            $image_id = $return['image_id'];
            //set image id to updated one
            $project_detail->setImageId($image_id);
            //update project
            if ($db->Update($project_detail, $project_detail_id)) {
                WriteLog("Update project detail image ", "Change project image with id: $project_detail_id");
                echo json_encode(array("status" => "1", "response" => "Project detail has been updated successfully", "error" => ""));
            } else {
                echo json_encode(array("status" => "0", "response" => "Project detail has not been updated successfully", "error" => "Cannot update project, please try again !"));
            }
        } else {
            echo json_encode(array("status" => "0", "response" => "Image has not been uploaded successfully", "error" => $return['error']));
            die();
        }
    } else {
        echo json_encode(array("status" => "0", "response" => "Project image is null", "error" => "Cannot update project, please try again !"));
    }
}

if ($function == "get_project_detail") {
    $project_id = $_REQUEST['project_id'];
    $sql = "SELECT * FROM project_detail WHERE project_id = $project_id ORDER BY project_detail_priority DESC";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

if ($function == "get_project_detail_image") {
    $project_detail_id = $_REQUEST['project_detail_id'];
    $sql = "SELECT * FROM project_detail 
            JOIN image ON project_detail.image_id = image.image_id
            WHERE project_detail_id = $project_detail_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

if ($function == "get_project_detail_text") {
    $project_detail_id = $_REQUEST['project_detail_id'];
    $sql = "SELECT * FROM project_detail WHERE project_detail_id = $project_detail_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

//function get all project
if ($function == "get_project") {
    $sql = "SELECT * FROM project JOIN category ON project.category_id = category.category_id ORDER BY project_id DESC";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

if ($function == "get_list_project") {
    $sql = "SELECT * FROM project  ORDER BY project_id DESC";
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

if ($function == "get_background_image") {
    $project_id = $_REQUEST['project_id'] == "" ? 0 : $_REQUEST['project_id'];
    $sql = "SELECT * FROM project JOIN image ON project.background_image_id = image.image_id WHERE project_id = $project_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

if ($function == "save_project_edit") {
    $project_id = $_REQUEST['project_id'] == "" ? 0 : $_REQUEST['project_id'];
    $project_name = $_REQUEST['project_name'] == "" ? "" : $_REQUEST['project_name'];
    $project_content = $_REQUEST['project_content'] == "" ? "" : $_REQUEST['project_content'];
    $category_id = $_REQUEST['category_id'] == "" ? 0 : $_REQUEST['category_id'];
    $project_status = $_REQUEST['project_status'] == "" ? 0 : $_REQUEST['project_status'];
    $sql = "SELECT * FROM project WHERE project_id = $project_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);

    $image_id = $result[0]['image_id'] == "" ? null : $result[0]['image_id'];
    $background_image_id = $result[0]['background_image_id'] == "" ? null : $result[0]['background_image_id'];


    //get old project
    $project = new project();
    $project->project_name = $project_name;
    $project->project_content = $project_content;
    $project->project_status = $project_status;
    $project->image_id = $image_id;
    $project->background_image_id = $background_image_id;
    $project->category_id = $category_id;



    $db = new DBConnection();
    if ($db->Update($project, $project_id)) {
        WriteLog("Update project", "Upadate project with id: $project_id");
        echo json_encode(array("status" => "1", "response" => "Project has been updated successfully", "error" => ""));
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

if ($function == "save_background_image_edit") {
    $project_id = $_REQUEST['project_id'] == "" ? 0 : $_REQUEST['project_id'];
    $sql = "SELECT * FROM project WHERE project_id = $project_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    $image_id = 0;
    //get project
    $project = new project();
    $project->project_name = $result[0]['project_name'];
    $project->project_content = $result[0]['project_content'];
    $project->project_status = $result[0]['project_status'];
    $project->image_id = $result[0]['image_id'];
    $project->category_id = $result[0]['category_id'];


    //upload file to sv
    $file = null;
    if (isset($_FILES['project_background_image'])) {
        $file = $_FILES['project_background_image'];
    }
    if ($file != null) {
        $return = UploadImage($file, $project_id, true);
        if ($return['status'] == "1") {
            $image_id = $return['image_id'];
            //set image id to updated one
            $project->background_image_id = $image_id;
            //update project
            if ($db->Update($project, $project_id)) {
                WriteLog("Update project", "Change project image with id: $project_id");
                echo json_encode(array("status" => "1", "response" => "Project has been updated successfully", "error" => ""));
            } else {
                echo json_encode(array("status" => "0", "response" => "Project has not been updated successfully", "error" => "Cannot update project, please try again !"));
            }
        } else {
            echo json_encode(array("status" => "0", "response" => "Image has not been uploaded successfully", "error" => $return['error']));
            die();
        }
    } else {
        //remove current 
        $project->background_image_id = null;
        if ($db->Update($project, $project_id)) {
            WriteLog("Update project", "Remove project image with id: $project_id");
            echo json_encode(array("status" => "1", "response" => "Project has been updated successfully", "error" => ""));
        } else {
            echo json_encode(array("status" => "0", "response" => "Project has not been updated successfully", "error" => "Cannot update project, please try again !"));
        }
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
    $project->background_image_id = $result[0]['background_image_id'];
    $project->category_id = $result[0]['category_id'];

    //upload file to sv
    $file = $_FILES['project_image_0'];
    if ($file != null) {
        $return = UploadImage($file, $project_id, true);
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
        echo json_encode(array("status" => "1", "response" => "Project has been updated successfully", "error" => ""));
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
    $category_id = $_POST['category_id'] == null ? 0 : $_POST['category_id'];

    $image_id = 0;
    $background_image_id = null;

    //create project ent
    $project = new project();
    $project->project_name = $project_name;
    $project->project_content = $project_content;
    $project->project_status = $project_status;
    $project->category_id = $category_id;
    //get lastId project id
    $db = new DBConnection();
    $lastId =  $db->GetLastId("project") + 1;
    //add image then get inserted id 
    $file = $_FILES['project_image_0'];
    //get background image_id 
    $file_background = $_FILES['project_background_image'];

    if ($file != null) {
        $return = UploadImage($file, $lastId, true);
        if ($return['status'] == "1") {
            $image_id =  $return['image_id'];
            if ($file_background == null) {
                $project->background_image_id = null;
            } else {
                $return_background = UploadImage($file_background, $lastId, true);
                $project->background_image_id = $return_background['image_id'];
            }
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
    } else {
        ob_end_clean();
        echo json_encode(array("status" => "0", "response" => "Could not find image file", "error" => $e->getMessage()));
    }
}

function UploadImage($imgae, $project_id, $isResize)
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
            //resize image
            if ($isResize) {
                $resize_result = resize_image($path, IMAGE_WIDTH, IMAGE_HEIGHT, true);
                if ("Success" != $resize_result) {
                    return array("image_id" => "", "status" => "0", "error" => "not a valid image type");
                }
                return array("image_id" => CreateImage($path), "status" => "1", "error" => "");
            } else {
                return array("image_id" => CreateImage($path), "status" => "1", "error" => "");
            }
        } else {
            return array("image_id" => "", "status" => "0", "error" => "You cannot upload files of this type");
        }
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

function resize_image($file, $w, $h, $crop = FALSE)
{
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width - ($width * abs($r - $w / $h)));
        } else {
            $height = ceil($height - ($height * abs($r - $w / $h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w / $h > $r) {
            $newwidth = $h * $r;
            $newheight = $h;
        } else {
            $newheight = $w / $r;
            $newwidth = $w;
        }
    }
    $src = null;
    switch (mime_content_type($file)) {
        case 'image/png':
            $src = imagecreatefrompng($file);
            break;
        case 'image/gif':
            $src = imagecreatefromgif($file);
            break;
        case 'image/jpeg':
            $src = imagecreatefromjpeg($file);
            break;
        case 'image/bmp':
            $src = imagecreatefrombmp($file);
            break;
        default:
            return "Error: File is not a valid image type";
            break;
    }

    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    //save file to system
    switch (mime_content_type($file)) {
        case 'image/png':
            imagepng($dst, $file);
            break;
        case 'image/gif':
            imagegif($dst, $file);
            break;
        case 'image/jpeg':
            imagejpeg($dst, $file);
            break;
        case 'image/bmp':
            imagebmp($dst, $file);
            break;
        default:
            return "Error: File is not a valid image type";
            break;
    }
    return "Success";
}
