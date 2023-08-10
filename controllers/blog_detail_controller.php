<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../ultis/DBConnection.php');

$blogId = 0 ;
if(isset($_REQUEST['id'])){
    $blogId = $_REQUEST['id'];
}
$_SESSION['blog'] = null;
$_SESSION['relativeBlogs'] = null;

getBlog($blogId);
getRelativeBlogs($blogId);

function getBlog($id){
    $sql = "SELECT * FROM blog JOIN image ON blog.image_id = image.image_id WHERE blog_status = '1' AND blog_id = '$id'";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    if($result != null){
        $_SESSION['blog'] =  $result;
    }
}

function getRelativeBlogs($id){
    $sql = "SELECT * FROM blog JOIN image ON blog.image_id = image.image_id WHERE blog_status = '1' AND blog_id != '$id' ORDER BY RAND() LIMIT 3";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    if($result != null){
        $_SESSION['relativeBlogs'] =  $result;
    }
}

?>