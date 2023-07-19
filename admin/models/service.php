<?php
class service
{
public $category_id;
public function GetCategoryId(){
 return $this->category_id;
}
public function SetCategoryId($category_id){
 $this->category_id = $category_id;
}

public $service_description;
public function GetServiceDescription(){
 return $this->service_description;
}
public function SetServiceDescription($service_description){
 $this->service_description = $service_description;
}

public $service_priority;
public function GetServicePriority(){
 return $this->service_priority;
}
public function SetServicePriority($service_priority){
 $this->service_priority = $service_priority;
}

public $service_name;
public function GetServiceName(){
 return $this->service_name;
}
public function SetServiceName($service_name){
 $this->service_name = $service_name;
}

public $service_status;
public function GetServiceStatus(){
 return $this->service_status;
}
public function SetServiceStatus($service_status){
 $this->service_status = $service_status;
}

public function __construct()
{

}
}
?>