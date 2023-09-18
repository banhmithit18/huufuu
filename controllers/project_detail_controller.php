<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../ultis/DBConnection.php');


$project_id = 0;
$content = "";
$project_name = "";


@get();

function get()
{
    $PATH = '../img/project_detail/';
    if (isset($_REQUEST['id'])) {
        $GLOBALS['project_id'] = $_REQUEST['id'];
        $sql = "SELECT * FROM project WHERE project_id = " . $GLOBALS['project_id'];
        $db = new DBConnection();
        $result = $db->Retrive($sql);
        if ($result > 0) {
            //check if has detail
            $hasDetail =  $result[0]['hasDetail'];
            if($hasDetail == 0){
                $GLOBALS['project_id'] = 0;
            }
            $GLOBALS['project_name'] = $result[0]['project_name'];
        }else{
            $GLOBALS['project_id'] = 0;
        }
    }

    try {
        $file = fopen($PATH . 'project_detail_' . $GLOBALS['project_id'] . '.txt', "r");
        if (filesize($PATH . 'project_detail_' . $GLOBALS['project_id'] . '.txt') > 0) {
            $GLOBALS['content'] = fread($file, filesize($PATH . 'project_detail_' . $GLOBALS['project_id'] . '.txt'));
        }
        fclose($file);
    } catch (Exception $e) {
        //do nothing
    }
}
$_SESSION['project_id']  = $project_id;
$_SESSION['content']  = $content;
$_SESSION['project_name']  = $project_name;
