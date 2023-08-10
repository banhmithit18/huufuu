<?php
require_once("../models/about_us.php");
require_once("../models/user.php");
class DBConnection {
private $servername = "localhost";
private $username = "root";
private $password = "";
private $database = "huufuu";
public function __construct()
{
    
}

//connect database
public function Connect(){
    $conn = new mysqli($this->servername,$this->username,$this->password,$this->database);
    if(mysqli_connect_error())
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

//get param type
function GetParamType($fields){
 $param_type = "";
 foreach($fields as $field)
 {
    switch (gettype($field))
    {
        case 'string':
            $type = "s";
            $param_type = "$param_type$type"; 
            break;
        case 'integer':
            $type = "i";
            $param_type = "$param_type$type"; 
            break;
        case 'double':
            $type = "d";
            $param_type = "$param_type$type"; 
            break;
        default:
        $type = "b";
        $param_type = "$param_type$type"; 
        break;
    }
 }
 return $param_type;
}
//create 
public function Create($item){
    //get class name
    $class_name = get_class($item);
    //get field properties
    $fields = get_object_vars($item);
    //create sql string
    $sql = "INSERT INTO $class_name (";
    $str_value = "";
    $param = array();
    foreach($fields as $field => $value)
    {
        array_push($param,$value);
        if($field  === array_key_last($fields))
        {
            $str_value = "$str_value?) ";
            $sql = "$sql$field) VALUES($str_value"; 
        }
        else{
            $str_value = "$str_value?, ";
            $sql = "$sql$field, "; 
        }       
    }
    //get param type
    $param_type = $this->GetParamType($param);
    $conn = $this->connect();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($param_type,...$param);
    try
    {
        $stmt->execute();
        $result = $stmt->affected_rows;
        if($result > 0)
        {
            $stmt->close();
            $conn->close();
            return true;
        }
        else
        {
            $stmt->close();
            $conn->close();
            return false;
        }
     
    }
    catch(Exception $e)
    {
        $conn -> rollback();
        $stmt->close();
        $conn->close();
        return false;
    }
}
//function check inject
public function CheckInject($str){
    $str = trim($str);
    $str = stripcslashes($str);
    $str = htmlspecialchars($str);
    return $str;
}

//function get last id after create
public function GetLastId($class_name){
    $conn = $this->connect();
    $sql = "SELECT * FROM $class_name ORDER BY " .$class_name."_id DESC LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    if(is_null($row)){
        return "0";
    }else{
        return $row[$class_name.'_id'];
    }
}

//function retrive data from statement  
public function Retrive($sql){ 
    ob_start();
    $conn = $this->connect();
    $sql = $this->CheckInject($sql);
    $result = $conn->query($sql) ;
    
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
        $conn->close();
        ob_flush();
      }
      else {
        ob_end_clean();
        if($conn ->affected_rows >0 )
        {
            $conn->close();
            return "success";
        }
        else
        {
            $conn->close();
            return "";
        }
      
      }
    
}
//function delete
public function Delete($item)
{
    //get class name
    $class_name = get_class($item);
    //get field properties
    $id_name = $class_name . "_id";
    $id = $item->$id_name;
    $sql = "DELETE FROM `$class_name` WHERE $id_name = ?";
    $conn = $this->connect();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt ->execute();
    if($conn -> affected_rows >0)
    {
        $stmt->close();
        $conn->close();
        return true;
    }
    else
    {
        $stmt->close();
        $conn->close();
        return false;
    }

}
//function update 
public function Update($item,$id){
    //get class name
    $class_name = get_class($item);
    //get field properties
    $fields = get_object_vars($item);
    //create sql string
    $sql = "UPDATE $class_name SET ";
    $param = array();
    foreach($fields as $field => $value)
    {
        array_push($param,$value);
        if($field  === array_key_last($fields))
        {
            $sql = "$sql$field = ? "; 
        }
        else{
            $sql = "$sql$field = ?, "; 
        }       
    }
    $sql = $sql. " WHERE " .$class_name ."_id = " .$id;
    //get param type
    $param_type = $this->GetParamType($param);
    $conn = $this->connect();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($param_type,...$param);
    $stmt ->execute();
    if($conn -> affected_rows >0)
    {
        $stmt->close();
        $conn->close();
        return true;
    }
    else
    {
        $stmt->close();
        $conn->close();
        return false;
    }
}
}


?>