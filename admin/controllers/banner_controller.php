<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/banner.php');
require_once('../models/image.php');

//get function from ajax
$function = "";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

//function update edit
if ($function == "edit_banner") {
    $db = new DBConnection();
    $banner_id = $_POST['banner_id'];
    $sql = "select * from banner where banner_id=" . $banner_id;
    $result = $db->Retrive($sql);

    $banner_title = $_POST['banner_title'];
    $banner_priority = $_POST['banner_priority'];
    $banner_status = $_POST['banner_status'];
    $banner_type = $_POST['banner_type'];
    $banner_link = $_POST['banner_link'];
    $banner_content = $_POST['banner_content'];



    $banner = new banner();
    $banner->SetBannerTitle($banner_title);
    $banner->SetBannerpriority($banner_priority);
    $banner->SetBannerStatus($banner_status);
    $banner->SetImageId($result[0]['image_id']);
    $banner->SetBannerContent($banner_content);
    $banner->SetBannerType($banner_type);
    $banner->SetBannerLink($banner_link);

    if ($db->Update($banner, $banner_id)) {
        WriteLog("Update banner", "Update banner with id = " . $banner_id);
        echo json_encode(array("status" => "1", "response" => "Banner has been updated successfully", "error" => ""));
        die();
    } else {
        echo json_encode(array("status" => "0", "response" => "Banner has not been updated successfully", "error" => "Banner has not been updated successfully, please try again later"));
        die();
    }
}

//function get banner
if ($function == "get_banner") {
    $sql = "SELECT * FROM banner join image on banner.image_id = image.image_id order by banner_id desc";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
    die();
}

//function add banner
if ($function == "add_banner") {
    //validate data
    $banner_title = $_POST['banner_title'] == null ? "" : $_POST['banner_title'];
    $banner_priority = $_POST['banner_priority'] == null ? 999 : $_POST['banner_priority'];
    $banner_status = $_POST['banner_status'] == null ? 0 : $_POST['banner_status'];
    $banner_image = $_FILES['banner_image'] == null ? "" : $_FILES['banner_image'];
    $banner_content = $_POST['banner_content'] == null ? "" : $_POST['banner_content'];
    $banner_type = $_POST['banner_type'] == null ? "" : $_POST['banner_type'];
    $banner_link = $_POST['banner_link'] == null ? "" : $_POST['banner_link'];


    //step 1 : create banner and get its id
    $db = new DBConnection();
    $banner = new banner();
    $banner->SetBannerTitle($banner_title);
    $banner->SetBannerpriority($banner_priority);
    $banner->SetBannerStatus($banner_status);
    $banner->SetBannerContent($banner_content);
    $banner->SetBannerLink($banner_link);
    $banner->SetBannerType($banner_type);
    $banner->SetImageId(null);
    //add banner to database
    if ($db->Create($banner)) {
        $banner_id = $db->GetLastId("banner");
        //step 2 : upload image
        if ($banner_image != "") {
            $return = UploadImage($banner_image, $banner_id);
            if ($return['status'] == 1) {
                $banner->SetImageId($return['image_id']);
                //step 3 : update banner content
                if ($db->Update($banner, $banner_id)) {
                    WriteLog("Add banner", "Add banner with id = " . $banner_id);
                    $return_message = (array('status' => '1', 'response' => 'Banner has been added successfully', 'error' => ''));
                    echo json_encode($return_message);
                    die();
                } else {
                    $return_message = (array('status' => '0', 'response' => 'Banner has not been added successfully', 'error' => 'Banner has not been added successfully'));
                    echo json_encode($return_message);
                    die();
                }
            } else {
                echo json_encode(array("status" => "0", "response" => "Image has not been uploaded successfully", "error" => $return['error']));
                die();
            }
        }
    } else {
        //return array error
        echo json_encode(array("status" => "0", "response" => "banner has not been saved successfully", "error" => "banner has not been saved successfully"));
    }
}




//write log
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

//function delete
if ($function == "delete_banner") {
    $banner_id = $_POST['banner_id'] == null ? '0' : $_POST['banner_id'];
    $banner = new banner();
    $banner->banner_id = $banner_id;
    $db = new DBConnection();
    if ($db->delete($banner)) {
        WriteLog("Delete banner", "Delete banner with id = $banner_id");
        echo json_encode(array("status" => "1", "response" => "Banner has not been deleted ", "error" => ""));
    } else {
        echo json_encode(array("status" => "0", "response" => "", "error" => "Banner has not been deleted, please try again later"));
        die();
    }
}

//get file from ajax and save to server and return path
function UploadImage($imgae, $banner_id)
{
    $image_path = "../../img/banner/";
    $file = $imgae;
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));
    $allowed = array('jpg', 'jpeg', 'png');
    if (in_array($file_ext, $allowed)) {
        if ($file_error === 0) {
            //genarate time stamp with banner id
            $time_stamp = time() . $banner_id;
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
    $sql = "SELECT * FROM banner join image on banner.image_id = image.image_id WHERE banner.image_id =" . $image_id;
    $ib = $db->Retrive($sql);
    //create image
    $image = UploadImage($image, $ib[0]['banner_id']);
    //create banner 
    $banner = new banner();
    $banner->banner_id = ($ib[0]['banner_id']);
    $banner->SetImageId($image['image_id']);
    $banner->SetBannerTitle($ib[0]['banner_title']);
    $banner->SetBannerpriority($ib[0]['banner_priority']);
    $banner->SetBannerStatus($ib[0]['banner_status']);
    $banner->SetBannerContent($ib[0]['banner_content']);
    $banner->SetBannerLink($ib[0]['banner_link']);
    $banner->SetBannerType($ib[0]['banner_type']);
    //update banner
    if ($db->Update($banner, $ib[0]['banner_id'])) {
        WriteLog("Update banner'thumb", "Update banner's image (banner id = " . $ib[0]['banner_id'] . ") with image id = " . $image_id);
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
