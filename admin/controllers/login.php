<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
if (!isset($_COOKIE["PHPSESSID"])) {
  session_start();
  $_SESSION['user_id'] = null;
  $_SESSION['user_username'] = null;
  $_SESSION['user_role'] = null;
  $_SESSION['user_address'] = null;
  $_SESSION['user_age'] = null;
  $_SESSION['user_email'] = null;
  $_SESSION['user_gender'] = null;
  $_SESSION['user_name'] = null;
  $_SESSION['user_phone'] = null;
  $_SESSION['user_status'] = null;
}
if (!isset($_SESSION["user_id"])) {

  $_SESSION['user_id'] = null;
  $_SESSION['user_username'] = null;
  $_SESSION['user_role'] = null;
  $_SESSION['user_address'] = null;
  $_SESSION['user_age'] = null;
  $_SESSION['user_email'] = null;
  $_SESSION['user_gender'] = null;
  $_SESSION['user_name'] = null;
  $_SESSION['user_phone'] = null;
  $_SESSION['user_status'] = null;
}


$function = "";
//get function from ajax 
if (isset($_REQUEST['function'])) {
  $function = $_REQUEST['function'];
}

if ($function == "login") {
  $username = $_POST['username'] == null ? "" : $_POST['username'];
  $password = $_POST['password'] == null ? "" : $_POST['password'];
  $sql = "SELECT * FROM user WHERE user_username = '$username'";
  $db = new DBConnection();
  $data = $db->Retrive($sql);
  if (empty($data)) {
    $return_message = (array('status' => '0', 'response' => 'Wrong username!', 'error' => ''));
    echo json_encode($return_message);
  } else {
    //check status
    $status =  $data[0]['user_status'];
    if ($status == "0") {
      $return_message = (array('status' => '0', 'response' => 'User is disabled!', 'error' => ''));
      echo json_encode($return_message);
      exit();
    }
    try {
      $user_password = $data[0]['user_pwd'];
      if (encrypt($password) == $user_password) {
        $_SESSION['user_id'] = $data[0]['user_id'];
        $_SESSION['user_username'] = $data[0]['user_username'];
        $_SESSION['user_role'] = $data[0]['user_role'];
        $_SESSION['user_address'] = $data[0]['user_address'];
        $_SESSION['user_age'] = $data[0]['user_age'];
        $_SESSION['user_email'] = $data[0]['user_email'];
        $_SESSION['user_gender'] = $data[0]['user_gender'];
        $_SESSION['user_name'] = $data[0]['user_name'];
        $_SESSION['user_phone'] = $data[0]['user_phone'];
        $_SESSION['user_status'] = $data[0]['user_status'];
        $return_message = (array('status' => '1', 'response' => 'Login succesfully', 'error' => ''));
        echo json_encode($return_message);
        exit();
      } else {
        $return_message = (array('status' => '0', 'response' => 'Wrong password!', 'error' => ''));
        echo json_encode($return_message);
        exit();
      }
    } catch (Exception $e) {
      $return_message = (array('status' => '0', 'response' => 'Wrong username!', 'error' => ''));
      echo json_encode($return_message);
      exit();
    }
  }
}

if ($function == "logout") {
  unset($_SESSION['user_id']);
  unset($_SESSION['user_username']);
  unset($_SESSION['user_role']);
  unset($_SESSION['user_address']);
  unset($_SESSION['user_age']);
  unset($_SESSION['user_email']);
  unset($_SESSION['user_gender']);
  unset($_SESSION['user_name']);
  unset($_SESSION['user_phone']);
  unset($_SESSION['user_status']);
  exit();
}

if ($_SESSION['user_id'] == null && !isset($_POST["usernaem"]) && !isset($_POST["password"])) {

  echo '<script>window.location.href = "../views/login.php";</script>';
}


function encrypt($pwd)
{
  $pwd = hash('sha256', $pwd);
  return $pwd;
}
