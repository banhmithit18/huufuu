<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/service.php');
require_once('../models/service_image.php');
require_once('../models/service_detail.php');
require_once('../models/image.php');

//get function from ajax
$function = "";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

//function get all service
if ($function == "get_service") {
    $sql = "SELECT * FROM service";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

if ($function == "get_image") {
    $service_id = $_REQUEST['service_id'] == "" ? 0 : $_REQUEST['service_id'];
    $sql = "SELECT * FROM service_image JOIN image ON service_image.image_id = image.image_id WHERE service_id = $service_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

if ($function == "get_detail") {
    $service_id = $_REQUEST['service_id'] == "" ? 0 : $_REQUEST['service_id'];
    $sql = "SELECT * FROM service_detail WHERE service_id = $service_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
}

if ($function == "save_service_edit") {
    $service_id = $_REQUEST['service_id'] == "" ? 0 : $_REQUEST['service_id'];
    $service_name = $_REQUEST['service_name'] == "" ? "" : $_REQUEST['service_name'];
    $service_description = $_REQUEST['service_description'] == "" ? "" : $_REQUEST['service_description'];
    $service_priority = $_REQUEST['service_priority'] == "" ? 0 : $_REQUEST['service_priority'];
    $category_id = $_REQUEST['category_id'] == "" ? 0 : $_REQUEST['category_id'];
    $service_status = $_REQUEST['service_status'] == "" ? 0 : $_REQUEST['service_status'];
    $service_price = $_REQUEST['service_price'] == "" ? 0 : $_REQUEST['service_price'];


    $service = new service();
    $service->service_name = $service_name;
    $service->service_description = $service_description;
    $service->service_priority = $service_priority;
    $service->category_id = $category_id;
    $service->service_status = $service_status == "1" ? 1 : false;
    $service->service_price = $service_price;

    $db = new DBConnection();
    if ($db->Update($service, $service_id)) {
        WriteLog("Update service", "Upadate service with id: $service_id");
        echo json_encode(array("status" => "1", "response" => "Service has been updated successfully", "error" => ""));
    } else {
        echo json_encode(array("status" => "0", "response" => "Service has not been updated successfully", "error" => "Cannot update service, please try again !"));
    }
}

if ($function == "delete_service") {
    $service_id = $_REQUEST['service_id'] == "" ? 0 : $_REQUEST['service_id'];
    $service = new service();
    $service->service_id = $service_id;
    $db = new DBConnection();


    if ($db->Delete($service)) {
        WriteLog("Delete service", "Delete service with id: $service_id");
        echo json_encode(array("status" => "1", "response" => "Service has been deleted successfully", "error" => ""));
    } else {
        echo json_encode(array("status" => "0", "response" => "Service has not been deleted successfully", "error" => "Cannot delete service, please check if service has been used !"));
    }
}

if ($function == "save_detail") {
    $service_id = $_REQUEST['service_id'] == "" ? 0 : $_REQUEST['service_id'];
    $service_detail = [];
    //delete old detail
    $sql = "DELETE FROM service_detail WHERE service_id = $service_id";
    $db = new DBConnection();
    $db->Retrive($sql);
    if(isset($_REQUEST['service_detail'])){
        $service_detail =  $_REQUEST['service_detail'];
        foreach ($service_detail as $detail) {
            if($detail == null)
            {
                continue;
            }
            $service_detail_obj = new service_detail();
            $service_detail_obj->service_id = $service_id;
            $service_detail_obj->service_detail_name = $detail['service_detail_name'];
            $service_detail_obj->service_detail_status = 1;
            $service_detail_obj->service_detail_value = $detail['service_detail_value'];
            $db->Create($service_detail_obj);
        }
    }
    WriteLog("Update service detail", "Upadate service detail with service id = $service_id");
    echo json_encode(array("status" => "1", "response" => "Service detail been updated successfully", "error" => ""));
}


if ($function == "save_image_edit") {
    $service_id = $_REQUEST['service_id'] == "" ? 0 : $_REQUEST['service_id'];
    $service_image_count = $_REQUEST['service_image_count'] == "" ? 0 : $_REQUEST['service_image_count'];
    $service_image_delete = $_REQUEST['service_image_delete'] == "" ? null : $_REQUEST['service_image_delete'];
    $sql = "select image_path from image join service_image on image.image_id = service_image.image_id where service_id = $service_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    $image_name = array();
    $image_service_id[] = null;

    $service_image_delete_arr = explode(",", $service_image_delete);
    foreach ($service_image_delete_arr as $item_delete) {
        if ($item_delete == null) {
            continue;
        }
        $pi = new service_image();
        $pi->service_image_id = $item_delete;
        $db->Delete($pi);
    }

    foreach ($result as $item) {
        //get image name from path
        $image_name[] = substr($item['image_path'], strrpos($item['image_path'], '/') + 1);
    }
    for ($i = 0; $i < $service_image_count; $i++) {
        //get file
        $file = $_FILES['service_image_' . $i];
        $service_image_id = $_REQUEST['service_image_id_' . $i] == "" ? 0 : $_REQUEST['service_image_id_' . $i];
        //check if file name is exist in array
        if (in_array($file['name'], $image_name)) {
            continue;
        }
        if ($file != null) {
            //check if has service image id 
            if ($service_image_id != 0) {
                $return = UploadImage($file, $service_id, false);
                if ($return['status'] == true) {
                    $sql = "select image.image_id,image_path,image_status from service_image join image on service_image.image_id = image.image_id where service_image_id = $service_image_id";
                    $Result = $db->Retrive($sql);
                    $image = new image();
                    $image->image_id = $Result[0]['image_id'];
                    $image->image_path =  $return['image_path'];
                    $image->image_status = $Result[0]['image_status'];
                    $db->Update($image, $image->image_id);;
                }
            } else {
                $return = UploadImage($file, $service_id, true);
                if ($return['status'] == true) {
                    array_push($image_service_id, $return['image_id']);
                } else {
                    $service = new Service();
                    $service->service_id = $service_id;
                    //delete service
                    $db->Delete($service);
                    echo json_encode(array("status" => "0", "response" => "Image has not been uploaded successfully", "error" => $return['error']));
                    die();
                    break;
                }
            }
        }
        foreach ($image_service_id as $image_id) {
            $service_image = new service_image();
            $service_image->service_id = $service_id;
            $service_image->image_id = $image_id;
            $db->Create($service_image);
        }
    }
    WriteLog("Update service image", "Update service image with service id " . $service_id);
    echo json_encode(array("status" => "1", "response" => "Image has been uploaded successfully"));
}

if ($function == "add_service") {
    //get data from ajax
    $service_name = $_POST['service_name'] == null ? "" : $_POST['service_name'];
    $service_priority = $_POST['service_priority'] == null ? 999 : $_POST['service_priority'];
    $category_id = $_POST['category_id'] == null ? 0 : $_POST['category_id'];
    $service_status = $_POST['service_status'] == null ? 0 : $_POST['service_status'];
    $service_price = $_POST['service_price'] == null ? "" : $_POST['service_price'];
    $service_detail = $_POST['service_detail'] == null ? "" : $_POST['service_detail'];
    $service_description = $_POST['service_description'] == null ? "" : $_POST['service_description'];
    $service_image_count = $_POST['service_image_count'] == null ? 0 : $_POST['service_image_count'];
    //step 1 : add service
    $service = new Service();
    $service->service_name = $service_name;
    $service->service_priority = $service_priority;
    $service->category_id = $category_id;
    $service->service_status = $service_status;
    $service->service_price = $service_price;
    $service->service_description = $service_description;
    $db = new DBConnection();
    if ($db->Create($service)) {
        //get last id service
        $service_id = $db->GetLastId("service");
        $image_service_id[] = null;
        //step 2 : add image service

        for ($i = 0; $i < $service_image_count; $i++) {
            //get file
            $file = $_FILES['service_image_' . $i];
            if ($file != null) {
                $return = UploadImage($file, $service_id, true);
                if ($return['status'] == "1") {
                    array_push($image_service_id, $return['image_id']);
                } else {
                    $service = new Service();
                    $service->service_id = $service_id;
                    //delete service
                    $db->Delete($service);
                    echo json_encode(array("status" => "0", "response" => "Image has not been uploaded successfully", "error" => $return['error']));
                    die();
                    break;
                }
            }
        }
        foreach ($image_service_id as $image_id) {
            if ($image_id == null) {
                continue;
            }
            $service_image = new service_image();
            $service_image->service_id = $service_id;
            $service_image->image_id = $image_id;
            $db->Create($service_image);
        }

        //step 3 : add service detail
        $service_detail = json_decode($service_detail);
        foreach ($service_detail as $detail) {
            $service_detail_obj = new service_detail();
            $service_detail_obj->service_id = $service_id;
            $service_detail_obj->service_detail_name = $detail->service_detail_name;
            $service_detail_obj->service_detail_status = 1;
            $service_detail_obj->service_detail_value = $detail->service_detail_value;
            $db->Create($service_detail_obj);
        }
        WriteLog("Add service", "Add service with service_id = " . $service_id);
        echo json_encode(array("status" => "1", "response" => "Service has been added successfully"));
    } else {
        echo json_encode(array("status" => "0", "response" => "Service has not been saved successfully", "error" => $e->getMessage()));
    }
}

function UploadImage($imgae, $service_id, $create)
{
    $image_path = "../../img/service/";
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
            $time_stamp = $file_name . time() . $service_id;
            $file_name_new = $time_stamp . "." . $file_ext;
            $file_destination = $image_path . $file_name_new;
            move_uploaded_file($file_tmp, $file_destination);
            $path = $file_destination;
            if ($create == true) {
                return array("image_id" => CreateImage($path), "status" => "1", "error" => "");
            } else {
                return array("image_path" => $path, "status" => "1", "error" => "");
            }
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
