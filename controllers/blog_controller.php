<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../ultis/DBConnection.php');

//default value session
$_SESSION['blogs'] = null;
$_SESSION['number_of_page']  = 1;
$_SESSION['current_page'] = 1;

if (isset($_REQUEST['current_page'])) {
    $page = $_REQUEST['current_page'] == null ? 1 : $_REQUEST['current_page'];
    $_SESSION['current_page'] = $page;
}

//get function from ajax
$function = "get_blog";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'] == null ? "get_blog" : $_REQUEST['function'];
}

//get nummber of project
function getNumberOfPage()
{
    $sql = "SELECT count(*) AS number_of_blog FROM blog JOIN image ON image.image_id = blog.image_id WHERE blog_status = 1";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    $number_of_page = ceil($result[0]['number_of_blog']/ 6);
    $_SESSION['number_of_page'] = $number_of_page;
    return $number_of_page;

}

//function get all project
if ($function == "get_blog") {
    getNumberOfPage();
    $sql = "SELECT * FROM blog
    JOIN image ON blog.image_id = image.image_id 
    WHERE blog_status = 1 LIMIT 6 OFFSET ". ($_SESSION['current_page']  - 1) * 6; 
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    if($result != null){
        $_SESSION['blogs'] =  $result;
    }
}

//function get next project
if ($function == "next_page") {
    $currentPage = $_REQUEST['current_page'];
    getNumberOfPage();
    $sql = "SELECT * FROM blog
    JOIN image ON blog.image_id = image.image_id 
    WHERE blog_status = 1 LIMIT 6 OFFSET ". ($_SESSION['current_page']  - 1) * 6; 
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    if($result != null){
        $blogs =  $result;
        for ($i = 0 ; $i < sizeof($blogs); $i++){
            $blogPath  = substr($blogs[$i]['blog_content_path'],3);
            $blogContnet = "";
            $file = fopen($blogPath, 'r');
            if ($file) {
                $blogContent = fread($file, 100);
                $blogContent = strip_tags($blogContent);
                fclose($file);
            } 
            array_push($blogs[$i],array("blog_content" => $blogContent));

        }
    //check if has next page or not 
        $numberOfPage = getNumberOfPage();
        if($numberOfPage > $currentPage ){
            echo json_encode(array("status" => "1", "response" => "Successful", "data" => $blogs,"isHaveNextPage" => true));
        }else{
            echo json_encode(array("status" => "1", "response" => "Successful", "data" => $blogs,"isHaveNextPage" => false));

        }
    }else{
        echo json_encode(array("status" => "0", "response" => "Data not found", "data" => null));
    }
}



