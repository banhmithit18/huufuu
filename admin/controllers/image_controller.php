<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/image.php');


$function = "";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}
if ($function == "get_image") {
    $db = new DBConnection();
    $sql = "SELECT image.image_id, image.image_path, 'Active' AS status, 'Service' AS type FROM image JOIN service_image ON image.image_id = service_image.image_id
    UNION 
    SELECT image.image_id, image.image_path, 'Active' AS status, 'Banner' AS type FROM image JOIN banner ON image.image_id = banner.image_id
    UNION
    SELECT image.image_id, image.image_path, 'Active' AS status, 'Blog' AS type FROM image JOIN blog ON image.image_id = blog.image_id
    UNION
    SELECT image.image_id, image.image_path, 'Inactive' AS status, '' AS type FROM image 
    WHERE image_id NOT IN( SELECT image.image_id FROM image JOIN blog ON image.image_id = blog.image_id UNION SELECT image.image_id FROM image JOIN service_image ON image.image_id = service_image.image_id UNION SELECT image.image_id FROM image JOIN banner ON image.image_id = banner.image_id )
    ORDER BY image_id";
    $result = $db->Retrive($sql);
    echo json_encode($result);
    die();
}
if ($function == 'delete_image') {
    $image_id = $_REQUEST['image_id'];
    $image = new image();
    $image->image_id = $image_id;
    $db = new DBConnection();
    $sql_get = "SELECT image_path FROM image WHERE image_id = $image_id";
    $image_path = $db->Retrive($sql_get);
    $sql = "SELECT image.image_id FROM image JOIN blog ON image.image_id = blog.image_id UNION SELECT image.image_id FROM image JOIN product_image ON image.image_id = product_image.image_id UNION SELECT image.image_id FROM image JOIN banner ON image.image_id = banner.image_id ";
    $result = $db->Retrive($sql);
    //check if variable is array or not
    if (is_array($result)) {
        foreach ($result as $item) {
            if ($item['image_id'] == $image_id) {
                $return_message = (array('status' => '0', 'response' => 'Cannot delete image', 'error' => 'Cannot delete image, please check if image is used in any product or blog'));
                echo json_encode($return_message);
                die();
            }
        }
    }

    if ($result = $db->Delete($image)) {
        //delete image from server
        if (file_exists($image_path[0]['image_path'])) {
            unlink($image_path[0]['image_path']);
        }
        $log = new Log();
        $log->SetLogDetail("Delete image with id = $image_id");
        $log->SetLogTime(date("Y-m-d H:i:s"));
        $log->SetUserId($_SESSION['user_id']);
        $log->SetLogName("Delete image");
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'Image has been deleted !', 'error' => ''));
        echo json_encode($return_message);
        die();
    } else {
        $return_message = (array('status' => '0', 'response' => 'Cannot delete image', 'error' => 'Cannot delete image, please check if image has been used'));
        echo json_encode($return_message);
        die();
    }
}
