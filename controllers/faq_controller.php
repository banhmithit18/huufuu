<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../ultis/DBConnection.php');
$_SESSION['faqs'] = null;

$sql = "SELECT * FROM faq where faq_Status = '1' ORDER BY faq_priority";
$db = new DBConnection();
$result = $db->Retrive($sql);
if($result != null){
    $_SESSION['faqs'] =  $result;
}
?>