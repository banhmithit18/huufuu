<?php
session_start();
require_once('../ultis/DBConnection.php');
require_once('../models/log.php');
require_once('../models/blog.php');
require_once('../models/image.php');

//get function from ajax
$function = "";
if (isset($_REQUEST['function'])) {
    $function = $_REQUEST['function'];
}

//function update edit
if ($function == "edit_blog") {
    $db = new DBConnection();
    $blog_id = $_POST['blog_id'];
    $sql = "select * from blog where blog_id=" . $blog_id;
    $result = $db->Retrive($sql);

    $blog_title = $_POST['blog_title'];
    $blog_priority = $_POST['blog_priority'];
    $blog_status = $_POST['blog_status'];

    $blog = new blog();
    $blog->SetBlogTitle($blog_title);
    $blog->SetBlogpriority($blog_priority);
    $blog->SetBlogStatus($blog_status);
    $blog->SetImageId($result[0]['image_id']);
    $blog->SetBlogContent($result[0]['blog_content_path']);

    if ($db->Update($blog, $blog_id)) {
        WriteLog("Update blog", "Update blog with id = " . $blog_id);
        echo json_encode(array("status" => "1", "response" => "Blog has been updated successfully", "error" => ""));
        die();
    } else {
        echo json_encode(array("status" => "0", "response" => "Blog has not been updated successfully", "error" => "Blog has not been updated successfully, please try again later"));
        die();
    }
}
//function delete
if ($function == "delete_blog") {
    $blog_id = $_POST['blog_id'] == null ? '0' : $_POST['blog_id'];
    $blog = new blog();
    $blog->blog_id = $blog_id;
    $db = new DBConnection();
    if ($db->delete($blog)) {
        WriteLog("Delete blog", "Delete blog with id = $blog_id");
        echo json_encode(array("status" => "1", "response" => "Blog has not been deleted ", "error" => ""));
    } else {
        echo json_encode(array("status" => "0", "response" => "", "error" => "Blog has not been deleted, please try again later"));
        die();
    }
}
//function get blog
if ($function == "get_blog") {
    $sql = "SELECT * FROM blog join image on blog.image_id = image.image_id order by blog_id desc";
    $db = new DBConnection();
    $result = $db->Retrive($sql);
    echo json_encode($result);
    die();
}

//function add blog
if ($function == "add_blog") {
    //validate data
    $blog_title = $_POST['blog_title'] == null ? "" : $_POST['blog_title'];
    $blog_priority = $_POST['blog_priority'] == null ? 999 : $_POST['blog_priority'];
    $blog_status = $_POST['blog_status'] == null ? 0 : $_POST['blog_status'];
    $blog_image = $_FILES['blog_image'] == null ? "" : $_FILES['blog_image'];
    $blog_content = $_POST['blog_content'] == null ? "" : $_POST['blog_content'];

    //step 1 : create blog and get its id
    $db = new DBConnection();
    $blog = new blog();
    $blog->SetBlogTitle($blog_title);
    $blog->SetBlogpriority($blog_priority);
    $blog->SetBlogStatus($blog_status);
    $blog->SetBlogContent("none");
    $blog->SetImageId(0);
    //add blog to database
    if ($db->Create($blog)) {
        $blog_id = $db->GetLastId("blog");
        //step 2 : upload image
        if ($blog_image != "") {
            $return = UploadImage($blog_image, $blog_id);
            if ($return['status'] == 1) {
                $blog->SetImageId($return['image_id']);
                //step 3 : update blog content
                if ($blog_content != "") {
                    $blog_content = urldecode($blog_content);
                    $return =  CreateBlogContent($blog_id, $blog_content);
                    if ($return != "") {
                        $blog->SetBlogContent($return);
                        //step 4 : update blog
                        if ($db->Update($blog, $blog_id)) {
                            WriteLog("Add blog", "Add blog with id = " . $blog_id);
                            $return_message = (array('status' => '1', 'response' => 'Blog has been added successfully', 'error' => ''));
                            echo json_encode($return_message);
                            die();
                        } else {
                            $return_message = (array('status' => '0', 'response' => 'Blog has not been added successfully', 'error' => 'Blog has not been added successfully'));
                            echo json_encode($return_message);
                            die();
                        }
                    } else {
                        $return = array('status' => '0', 'response' => 'Blog content has not been saved successfully', 'error' => 'Blog content has not been saved successfully');
                        echo json_encode($return);
                        die();
                    }
                }
            } else {
                echo json_encode(array("status" => "0", "response" => "Image has not been uploaded successfully", "error" => $return['error']));
                die();
            }
        }
    } else {
        //return array error
        echo json_encode(array("status" => "0", "response" => "Blog has not been saved successfully", "error" => $e->getMessage()));
    }
}


//write log
function WriteLog($log_name, $log_detail)
{
    //create log object
    $log = new log();
    $log->SetLogDetail($log_detail);
    $log->SetLogName($log_name);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $log->SetLogTime(date("Y-m-d H:i:s"));
    $log->SetUserId($_SESSION['user_id']);
    //create database object
    $db = new DBConnection();
    $db->Create($log);
}

//get file from ajax and save to server and return path
function UploadImage($imgae, $blog_id)
{
    $image_path = "../../img/blog/";
    $file = $imgae;
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));
    $allowed = array('jpg', 'jpeg', 'png');
    if (in_array($file_ext, $allowed)) {
        if ($file_error === 0) {
            if ($file_size <= 2097152) {
                //genarate time stamp with blog id
                $time_stamp = time() . $blog_id;
                $file_name_new = $time_stamp . "." . $file_ext;
                $file_destination = $image_path . $file_name_new;
                move_uploaded_file($file_tmp, $file_destination);
                $path = $file_destination;
                return array("image_id" => CreateImage($path), "status" => "1", "error" => "");
            } else {
                return array("image_id" => "", "status" => "0", "error" => "File size is too big");
            }
        } else {
            return array("image_id" => "", "status" => "0", "error" => "There was an error uploading your file");
        }
    } else {
        return array("image_id" => "", "status" => "0", "error" => "You cannot upload files of this type");
    }
}

//function get content from txt file
if ($function == "get_content_blog") {
    //create file if not exist
    $path = $_POST['content_path'];
    $file = fopen($path, "r");
    $content = fread($file, filesize($path));
    fclose($file);
    echo json_encode($content);
    die();
}

if ($function == "update_content") {
    $blog_id = $_POST['blog_id'] == null ? "" : $_POST['blog_id'];
    $content_path = $_POST['content_path'] == null ? "" : $_POST['content_path'];
    $content = $_POST['content'] == null ? "" : $_POST['content'];
    try {
        $file = fopen($content_path, "w");
        $content = urldecode($content);
        fwrite($file, $content);
        fclose($file);
        WriteLog("Update blog content", "Update blog content with blog id = " . $blog_id);
        $return_message = (array('status' => '1', 'response' => 'Content has been saved successfully', 'error' => ''));
        echo json_encode($return_message);
        die();
    } catch (Exception $e) {
        echo json_encode(array("status" => "0", "response" => "Content has not been saved successfully", "error" => $e->getMessage()));
        die();
    }
}

//function update image
if ($function == "update_image") {

    $image = $_FILES['image'] == null ? "" : $_FILES['image'];
    $image_id = $_POST['image_id'];
    $db = new DBConnection();
    //check sql injection
    $sql = "SELECT * FROM blog join image on blog.image_id = image.image_id WHERE blog.image_id =" . $image_id;
    $ib = $db->Retrive($sql);
    //create image
    $image = UploadImage($image, $ib[0]['blog_id']);
    //create blog 
    $blog = new blog();
    $blog->blog_id = $ib[0]['blog_id'];
    $blog->SetBlogTitle($ib[0]['blog_title']);
    $blog->SetBlogpriority($ib[0]['blog_priority']);
    $blog->SetBlogStatus($ib[0]['blog_status']);
    $blog->SetBlogContent($ib[0]['blog_content_path']);
    $blog->SetImageId($image['image_id']);
    //update blog
    if ($db->Update($blog, $ib[0]['blog_id'])) {
        WriteLog("Update blog'thumb", "Update blog'thumb image (blog id = " . $ib[0]['blog_id'] . ") with image id = " . $image_id);
        $return_message = (array('status' => '1', 'response' => 'Image has been updated successfully', 'error' => ''));
        echo json_encode($return_message);
        die();
    } else {
        $return_message = (array('status' => '0', 'response' => 'Image has not been updated successfully', 'error' => 'Image has not been updated successfully'));
        echo json_encode($return_message);
        die();
    }
}

//function create image
function CreateImage($image_path)
{
    $image = new Image();
    $image->SetImagePath($image_path);
    $image->SetImageStatus(1);
    $db = new DBConnection();
    $db->Create($image);
    $image_id = $db->GetLastId("image");
    return $image_id;
}

//function create blog content to txt file and return path
function CreateBlogContent($blog_id, $blog_content)
{
    $blog_content_path = "../../img/blog/content/";
    $file_name = $blog_id . ".txt";
    $file_destination = $blog_content_path . $file_name;
    try {
        $file = fopen($file_destination, "w");
        fwrite($file, $blog_content);
        fclose($file);
        return $file_destination;
    } catch (Exception $e) {
        return "";
    }
}
