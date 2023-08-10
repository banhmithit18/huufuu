<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../ultis/DBConnection.php');
require_once('../admin/models/customer.php');
require_once('../admin/models/contact_us.php');

//default value session
$_SESSION['feedbacks'] = null;

getFeedback();

function getFeedback(){
    $sql = "SELECT *  FROM feedback
    JOIN image ON feedback.image_id = image.image_id 
    WHERE feedback_status = 1 ORDER BY feedback_priority";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    if($result != null){
        $_SESSION['feedbacks'] =  $result;
    }
}

?>