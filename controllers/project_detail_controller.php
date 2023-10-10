<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../ultis/DBConnection.php');


$_SESSION['project_detail'] = null;
$_SESSION['project_name'] = null;

getProjectName();
@get();

function getProjectName(){
    $project_id = $_REQUEST['id'];
        $sql = "SELECT * FROM project WHERE project_id = $project_id";
        $db = new DBConnection();
        $result = $db->Retrive($sql);
        $_SESSION['project_name'] = $result[0]['project_name'];
}

function get()
{
    if (isset($_REQUEST['id'])) {

        $project_id = $_REQUEST['id'];
        $sql = "SELECT * FROM project_detail 
                LEFT JOIN image ON project_detail.image_id = image.image_id WHERE project_id = $project_id AND project_detail_status = 1 ORDER BY project_detail_priority";
        $db = new DBConnection();
        $result = $db->Retrive($sql);
        if ($result != null) {
            $lists = array();

            // Loop through the result and separate data by project_detail_priority
            foreach ($result as $row) {
                $priority = $row['project_detail_priority'];

                // If the priority is not yet in the lists, add it
                if (!isset($lists[$priority])) {
                    $lists[$priority] = array();
                }

                // Add the row to the appropriate list
                $lists[$priority][] = $row;
            }
            $_SESSION['project_detail'] =  $lists;
        }
    }
}
