<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../ultis/DBConnection.php');

//default value session
$_SESSION['categoriesSer'] = null;
$_SESSION['services'] = null;
$_SESSION['number_of_page']  = 1;
$_SESSION['current_page'] = 1;
$_SESSION['current_category'] = 0;

//get function from ajax
$function = "get_service";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'] == null ? "get_service" : $_REQUEST['function'];
}

//should i least have 1 category
if (isset($_REQUEST['current_page'])) {
    $page = $_REQUEST['current_page'] == null ? 1 : $_REQUEST['current_page'];
    $_SESSION['current_page'] = $page;
}

if (isset($_REQUEST['current_category'])) {
    $current_category = $_REQUEST['current_category'] == null ? 0 : $_REQUEST['current_category'];
    $_SESSION['current_category'] = $current_category;
}

function getCategorySer(){
    $sql = "SELECT * from category WHERE category_status = 1 ";
    $db = new DBConnection();
    $categoriesSer = $db->Retrive($sql);
    $_SESSION['categoriesSer']  = $categoriesSer;
    //get first category
    if($categoriesSer != null){
        if(sizeof($categoriesSer) > 0 && $_SESSION['current_category'] == 0){
            $_SESSION['current_category'] = $categoriesSer[0]['category_id'];
        }
    }
}

//get nummber of project
function getNumberOfPage()
{
    $current_category = $_SESSION['current_category'];
    $sql = "SELECT count(*) AS number_of_service FROM service JOIN category ON category.category_id = service.category_id WHERE service_status = 1 AND category_status = 1 AND service.category_id = $current_category ";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    $number_of_page = ceil($result[0]['number_of_service']/ 3);
    $_SESSION['number_of_page'] = $number_of_page;
    return $number_of_page;

}

function getServiceDetail($service_id){
    $sql = "SELECT * FROM service_detail WHERE service_id = '$service_id' AND service_detail_status = 1 ORDER BY service_detail_id";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    return $result;
}

//function get all project
if ($function == "get_service") {
    getCategorySer();
    getNumberOfPage();
    $current_category = $_SESSION['current_category'];
    $sql = "SELECT * FROM service JOIN category ON category.category_id = service.category_id 
                JOIN service_image ON service_image.service_id = service.service_id
                JOIN image ON image.image_id = service_image.image_id  
            WHERE service_status = 1 AND category_status = 1 AND service.category_id = $current_category 
            ORDER BY service_priority 
            LIMIT 3 OFFSET ". ($_SESSION['current_page']  - 1) * 3; 
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    if($result != null){
        $services = $result;
        //get detail
        for($i = 0; $i < sizeof($services); $i++){
            $service_id = $services[$i]['service_id'];
            $details = getServiceDetail($service_id);
            $services[$i]['details'] = $details;
        }
        $_SESSION['services'] =  $services;
    }
}

//getfuction get nextpage
if($function == "next_page"){
    $current_page = $_REQUEST['current_page'];
    $current_category = $_REQUEST['current_category'];
    $sql = "SELECT * FROM service JOIN category ON category.category_id = service.category_id 
                JOIN service_image ON service_image.service_id = service.service_id
                JOIN image ON image.image_id = service_image.image_id  
            WHERE service_status = 1 AND category_status = 1 AND service.category_id = $current_category 
            ORDER BY service_priority 
            LIMIT 3 OFFSET ". ($current_page  - 1) * 3; 
    $services = null;
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    if($result != null){
        $services = $result;
        //get detail
        for($i = 0; $i < sizeof($services); $i++){
            $service_id = $services[$i]['service_id'];
            $details = getServiceDetail($service_id);
            $services[$i]['details'] = $details;
        }
        //check if has next page or not 
        $number_of_page = getNumberOfPage();
        if($number_of_page > $current_page ){
            echo json_encode(array("status" => "1", "response" => "Successful", "data" => $services,"isHaveNextPage" => true));
        }else{
            echo json_encode(array("status" => "1", "response" => "Successful", "data" => $services,"isHaveNextPage" => false));

        }

    }else{
        echo json_encode(array("status" => "0", "response" => "Data not found", "data" => null));
    }



}




