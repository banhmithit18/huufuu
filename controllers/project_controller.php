<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../ultis/DBConnection.php');

//default value session
$_SESSION['projects'] = null;
$_SESSION['number_of_page']  = 1;
$_SESSION['current_page'] = 1;

if (isset($_REQUEST['current_page'])) {
    $page = $_REQUEST['current_page'] == null ? 1 : $_REQUEST['current_page'];
    $_SESSION['current_page'] = $page;
}

//get function from ajax
$function = "get_project";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'] == null ? "get_project" : $_REQUEST['function'];
}

//get nummber of project
function getNumberOfPage()
{
    $sql = "SELECT count(*) AS number_of_project FROM project JOIN image ON image.image_id = project.image_id WHERE project_status = 1";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    $number_of_page = ceil($result[0]['number_of_project']/ 12);
    $_SESSION['number_of_page'] = $number_of_page;
    return $number_of_page;

}

//function get all project
if ($function == "get_project") {
    getNumberOfPage();
    $sql = "SELECT project_id,project_name,project_content,image.image_path, background.image_path as 'background_image_path' FROM project
    JOIN image ON project.image_id = image.image_id 
    LEFT JOIN image background ON project.background_image_id = background.image_id 
    WHERE project_status = 1 LIMIT 12 OFFSET ". ($_SESSION['current_page']  - 1) * 12; 
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    if($result != null){
        $_SESSION['projects'] =  $result;
    }
}

//function get next project
if ($function == "next_page") {
    $currentPage = $_REQUEST['current_page'];
    getNumberOfPage();
    $sql = "SELECT project_id,project_name,project_content,image.image_path, background.image_path as 'background_image_path' FROM project
    JOIN image ON project.image_id = image.image_id 
    LEFT JOIN image background ON project.background_image_id = background.image_id 
    WHERE project_status = 1 LIMIT 12 OFFSET ". ($currentPage  - 1) * 12; 
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    if($result != null){
        $projects =  $result;
        //check if has next page or not 
        $numberOfPage = getNumberOfPage();
        if($numberOfPage > $currentPage ){
            echo json_encode(array("status" => "1", "response" => "Successful", "data" => $projects,"isHaveNextPage" => true));
        }else{
            echo json_encode(array("status" => "1", "response" => "Successful", "data" => $projects,"isHaveNextPage" => false));

        }
    }else{
        echo json_encode(array("status" => "0", "response" => "Data not found", "data" => null));
    }

}



