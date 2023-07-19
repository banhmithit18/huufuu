<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');

//function get log from database
$db = new DBConnection();
$sql = "SELECT log_name,log_detail,user.user_username,log_time FROM log JOIN user on log.user_id = user.user_id order by log_id desc";
$result = $db->Retrive($sql);
echo json_encode($result);
?>