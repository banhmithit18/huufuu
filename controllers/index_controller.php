<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../ultis/DBConnection.php');

$_SESSION['headerLogo'] = "";
$_SESSION['footerLogo'] = "";
$_SESSION['facebookLink'] = "";
$_SESSION['twitterLink'] = "";
$_SESSION['linkedinLink'] = "";
$_SESSION['introduce'] = "";

getLogo ();
getMedia();
//get logo
function getLogo (){
    $db = new DBConnection();
    $sql = "SELECT logo.*, image.image_path FROM logo JOIN image ON image.image_id = logo.image_id WHERE image.image_status = '1'";
    $result = $db->Retrive($sql);
    for ($i = 0 ; $i < sizeof($result) ; $i++){
        if($result[$i]['logo_location'] == "1"){
            $_SESSION['headerLogo'] = substr($result[$i]['image_path'],3);
        }
        if($result[$i]['logo_location'] == "2"){
            $_SESSION['footerLogo'] = substr($result[$i]['image_path'],3);
        }
    }
}

//get media
function getMedia (){
    $db = new DBConnection();
    $sql = "SELECT * FROM media";
    $result = $db->Retrive($sql);
    for ($i = 0 ; $i < sizeof($result) ; $i++){
        if($result[$i]['media_type'] == "1"){
            $_SESSION['facebookLink'] = $result[$i]['media_value'];
        }
        if($result[$i]['media_type'] == "2"){
            $_SESSION['twitterLink'] = $result[$i]['media_value'];
        }
        if($result[$i]['media_type'] == "3"){
            $_SESSION['linkedinLink'] = $result[$i]['media_value'];
        }
        if($result[$i]['media_type'] == "4"){
            $_SESSION['introduce'] = $result[$i]['media_value'];
        }
    }
}   

?>