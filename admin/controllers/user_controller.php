<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/user.php');
//check permission

$function = "";
$user_role = "1";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

if (isset($_SESSION['user_role'])) {
    $user_role = $_SESSION['user_role'];
}

$page_type = "";
//function get user from database
if ($function == "get_user") {
    if($user_role != 0)
    {
        $result = [];
        echo json_encode($result);
        die();
    }
    $db = new DBConnection();
    $sql = "SELECT * FROM user ORDER BY user_id desc";
    $result = $db->Retrive($sql);
    echo json_encode($result);
    die();
}

//function check username exist or not
function CheckExist($value, $type)
{
    $db = new DBConnection();
    if ($type == "username") {
        $sql = "SELECT * FROM user WHERE user_username = '$value'";
    } else if ($type == "email") {
        $sql = "SELECT * FROM user WHERE user_email = '$value'";
    } else if ($type == "phone") {
        $sql = "SELECT * FROM user WHERE user_phone = '$value'";
    }
    $result = $db->Retrive($sql);
    if ($result == "" ||$result == null) {
        return false;
    } else {
        return true;
    }
}

//function delete user from database
if ($function == "delete_user") {
    $user_id = $_REQUEST['user_id'];
    $db = new DBConnection();
    $user = new user();
    $user -> user_id = $user_id;
    if($result = $db->Delete($user)){
        $log = new Log();
        $log->SetLogDetail("Delete user with id = $user_id");
        $log->SetLogTime(date("Y-m-d H:i:s"));
        $log->SetUserId($_SESSION['user_id']);
        $log->SetLogName("Delete user");
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'User has been deleted !', 'error' => ''));
        echo json_encode($return_message);
        die();
    }
    else
    {
        $return_message = (array('status' => '0', 'response' => 'Cannot delete user', 'error' => 'Check if user has been used !'));
        echo json_encode($return_message);
        die();
    }
    
}

//function add user to database
if ($function == "add_user") {
    $user = new User();
    //validate
    $user_username = $_POST['user_username'] == null ? "" : $_POST['user_username'];
    $user_address = $_POST['user_address'] == null ? "" : $_POST['user_address'];
    $user_phone = $_POST['user_phone'] == null ? "" : $_POST['user_phone'];
    $user_email = $_POST['user_email'] == null ? "" : $_POST['user_email'];
    $user_age = $_POST['user_age'] == null ? "" : $_POST['user_age'];
    $user_gender = $_POST['user_gender'] == null ? 0 : $_POST['user_gender'];
    $user_name = $_POST['user_name'] == null ? "" : $_POST['user_name'];
    $user_pwd = $_POST['user_pwd'] == null ? "" : encrypt($_POST['user_pwd']);
    $user_status = $_POST['user_status'] == null ? 0 : $_POST['user_status'];
    $user_role = $_POST['user_role'] == null ? 1 : $_POST['user_role'];
    //check exist
    if ($check_exist = CheckExist($user_username, "username")) {
        $return_message = (array('status' => '0', 'response' => 'Username already exist', 'error' => 'Username already exist'));
        echo json_encode($return_message);
        die();
    }
    if ($check_exist = CheckExist($user_email, "email")) {
        $return_message = (array('status' => '0', 'response' => 'Email already exist', 'error' => 'Email already exist'));
        echo json_encode($return_message);
        die();
    }
    if ($check_exist = CheckExist($user_phone, "phone")) {
        $return_message = (array('status' => '0', 'response' => 'Phone number already exist', 'error' => 'Phone number already exist'));
        echo json_encode($return_message);
        die();
    }
    //create entity
    $user->SetUserName($user_name);
    $user->SetUserAddress($user_address);
    $user->SetUserAge($user_age);
    $user->SetUserEmail( $user_email);
    $user->SetUserGender( $user_gender);
    $user->SetUserPhone($user_phone);
    $user->SetUserUsername($user_username);
    $user->SetUserPwd( $user_pwd);
    $user->SetUserStatus($user_status);
    $user->SetUserRole($user_role);
    //insert
    $db = new DBConnection();;
    try {
        $db->Create($user);
        $log = new Log();
        $log->SetLogName("Add user");
        $log->SetLogDetail("Add user $user_name");
        $log->SetUserId($_SESSION['user_id']);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $log->SetLogTime($date);
        $db->Create($log);
    }catch (Exception $e) {
        $return_message = (array('status' => '0', 'response' => 'Error', 'error' => $e->getMessage()));
        echo json_encode($return_message);
        die();
    }

    $return_message = (array('status' => '1', 'response' => 'User has been added', 'error' => '', 'user_data' => $user));
    echo json_encode($return_message);
    die();
}

//function update user to database
if ($function == "update_user") {
    $user = new User();
    //validate
    $user_id = $_POST['user_id'] == null ? 0 : $_POST['user_id'];
    $user_username = $_POST['user_username'] == null ? "" : $_POST['user_username'];
    $user_address = $_POST['user_address'] == null ? "" : $_POST['user_address'];
    $user_phone = $_POST['user_phone'] == null ? "" : $_POST['user_phone'];
    $user_email = $_POST['user_email'] == null ? "" : $_POST['user_email'];
    $user_age = $_POST['user_age'] == null ? "" : $_POST['user_age'];
    $user_gender = $_POST['user_gender'] == null ? 0 : $_POST['user_gender'];
    $user_name = $_POST['user_name'] == null ? "" : $_POST['user_name'];
    $user_status = $_POST['user_status'] == null ? 0 : $_POST['user_status'];
    $user_role = $_POST['user_role'] == null ? 0 : $_POST['user_role'];

    //create ent
    $user->SetUserUsername($user_username);
    $user->SetUserAddress( $user_address);
    $user->SetUserAge($user_age);
    $user->SetUserEmail($user_email);
    $user->SetUserGender($user_gender);
    $user->SetUserName($user_name);
    $user->SetUserPhone($user_phone);
    $user->SetUserStatus($user_status);
    $user->SetUserRole($user_role);
    $user->user_id = $user_id;

    //create ent old user\
    $db = new DBConnection();
    $result  = $db -> Retrive("SELECT * FROM user WHERE user_id = $user_id");
    $user->SetUserPwd( $result[0]['user_pwd']);

    if($result[0]['user_email'] != $user_email){
        $check_exist = CheckExist($user_email, "email");
        if($check_exist){
            $return_message = (array('status' => '0', 'response' => 'Email already exist', 'error' => 'Email already exist'));
            echo json_encode($return_message);
            die();
        }
    }
    else if($result[0]['user_phone'] != $user_phone){
        $check_exist = CheckExist($user_phone, "phone");
        if($check_exist){
            $return_message = (array('status' => '0', 'response' => 'Phone number already exist', 'error' => 'Phone number already exist'));
            echo json_encode($return_message);
            die();
        }
    }


    //get page type (type = admin: write log, type = user: not write log)    
    $page_type = $_POST['page_type'] == null ? "admin" : $_POST['page_type'];
    //update
    $db = new DBConnection();;
    if ($db->Update($user, $user_id)) {
        if ($page_type == "admin") {
            $log = new Log();
            $log->SetLogName("Update user");
            $log->SetLogDetail("Update user $user_name");
            $log->SetUserId($_SESSION['user_id']);
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date('Y-m-d H:i:s');
            $log->SetLogTime($date);
            $db->Create($log);
            $return_message = (array('status' => '1', 'response' => 'User has been updated', 'error' => ''));
            echo json_encode($return_message);
            die();
        } else {
            $_SESSION['user_address'] =  $user_address;
            $_SESSION['user_age'] = $user_age;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['user_gender'] = $user_gender;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_phone'] =  $user_phone;
            $return_message = (array('status' => '1', 'response' => 'User has been updated', 'error' => ''));
            echo json_encode($return_message);
            die();
        }       
    }else
    {
        $return_message = (array('status' => '0', 'response' => 'Cannot update user!', 'error' => 'Cannot update user!'));
        echo json_encode($return_message);
        die();   
    }
    die();
}

if($function == "change_password")
{
 
        $new_pwd = $_POST['new_password'] == null ? "" : encrypt($_POST['new_password']);
        $old_pwd = $_POST['old_password'] == null ? "" : encrypt($_POST['old_password']);
        $user_id = $_POST['user_id'] == null ? "" : $_POST['user_id'];

        $db = new DBConnection();
        $sql = "SELECT user_id FROM user where user_id='$user_id' and user_pwd = '$old_pwd'";
        $result = $db -> Retrive($sql);
        if(empty($result))
        {
            $return_message = (array('status' => '0', 'response' => 'Wrong password, please try again!', 'error' => ''));
            echo json_encode($return_message);
            die();    
        }
        else
        {
            $sql = "update user set user_pwd = '$new_pwd' where user_id='$user_id' ";
            $result = $db -> Retrive($sql);
            if(empty($result))
            {
                $return_message = (array('status' => '0', 'response' => 'Cannot change password, please try if password is the same as before!', 'error' => ''));
                echo json_encode($return_message);
                die();    
            }
            else
            {
                $return_message = (array('status' => '1', 'response' => 'Password has been change!', 'error' => ''));
                echo json_encode($return_message);
                die();
            }
        }

    
}

//function reset password
if ($function == "reset_password"){
    
    $user_id = $_POST['user_id'] == null ? 0 : $_POST['user_id'];
    //reset password 
    $user_pwd = encrypt("macylantern");
    $db = new DBConnection();
    try{
    $result = $db->Retrive("UPDATE user SET user_pwd = '$user_pwd' WHERE user_id = $user_id");}
    catch(Exception $e){
        $e->getMessage();
        $return_message = (array('status' => '0', 'response' => 'Reset passwrod for user failed', 'error' => $e));
        echo json_encode($return_message);
        die();
    }
    if($result == "")
    {
        $return_message = (array('status' => '0', 'response' => 'Reset passwrod for user failed', 'error' => 'Reset passwrod for user failed'));
        echo json_encode($return_message);
        die();
    }
    else{
        $log = new Log();
        $log->SetLogName("Reset password");
        $log->SetLogDetail("Reset password for user id =  $user_id");
        $log->SetUserId($_SESSION['user_id']);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        $log->SetLogTime($date);
        $db->Create($log);
        $return_message = (array('status' => '1', 'response' => 'Reset passwrod for user successfully', 'error' => ''));
        echo json_encode($return_message);
        die();
    }
}


//function encrypt password with sha256
function encrypt($pwd)
{
    $pwd = hash('sha256', $pwd);
    return $pwd;
}
