<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/category.php');

$function = "";
//get function from ajax 
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

//function get category
if ($function == "get_category") {
    $db = new DBConnection();
    $sql = "SELECT * FROM category ORDER BY category_id DESC";
    $result = $db->Retrive($sql);
    echo json_encode($result);
    die();
}

//function add category
if ($function == "add_category") {
    $category = new category();
    //validate data
    $category_name = $_POST['category_name'] == null ? "" : $_POST['category_name'];
    $category_status = $_POST['category_status'] == null ? 0 : $_POST['category_status'];

    //set data
    $category->SetCategoryName($category_name);
    $category->SetCategoryStatus($category_status);


    //insert data
    $db = new DBConnection();;
    try {
        $db->Create($category);
        $log = new log();
        $log->SetLogName("Add category");
        $log->SetLogDetail("Add category question: " . $category_name);
        $log->SetUserId($_SESSION['user_id']);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $log->SetLogTime($date);
        $db->Create($log);
    } catch (Exception $e) {
        $return_message = (array('status' => '0', 'response' => 'Error', 'error' => $e->getMessage()));
        echo json_encode($return_message);
        die();
    }

    $return_message = (array('status' => '1', 'response' => 'Category has been added', 'error' => '', 'category_data' => $category));
    echo json_encode($return_message);
    die();
}

//function update category
if ($function == "update_category") {
    $category = new category();
    //validate data
    $category_id = $_POST['category_id'] == null ? "" : $_POST['category_id'];
    $category_name = $_POST['category_name'] == null ? "" : $_POST['category_name'];
    $category_status = $_POST['category_status'] == null ? 0 : $_POST['category_status'];

    //set data
    $category->SetCategoryName($category_name);
    $category->SetCategoryStatus($category_status);
    $category->category_id = $category_id;
    //update data
    $db = new DBConnection();;
    if ($db->Update($category, $category_id)) {
        $log = new log();
        $log->SetLogName("Update category");
        $log->SetLogDetail("Update category with id: " . $category_id);
        $log->SetUserId($_SESSION['user_id']);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $log->SetLogTime($date);
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'Category has been updated', 'error' => '', 'category_data' => $category));
        echo json_encode($return_message);
        die();
    } else {
        $return_message = (array('status' => '0', 'response' => 'Error', 'error' => $e->getMessage()));
        echo json_encode($return_message);
        die();
    }
}


//function delete category
if ($function == "delete_category") {
    $category_id = $_POST['category_id'] == null ? 0 : $_POST['category_id'];
    $category = new category();
    $category->category_id = $category_id;
    $db = new DBConnection();
    if ($db->Delete($category)) {
        $log = new Log();
        $log->SetLogName("Delete category");
        $log->SetLogDetail("Delete category with id: " . $category_id);
        $log->SetUserId($_SESSION['user_id']);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $log->SetLogTime($date);
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'Category has been deleted', 'error' => ''));
        echo json_encode($return_message);
        die();
    } else {
        $return_message = (array('status' => '0', 'response' => 'Error', 'error' => 'Check if category has been used ! '));
        echo json_encode($return_message);
        die();
    }
}
