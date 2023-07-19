<?php
class service_detail
{


public $service_detail_name;
public function GetServiceDetailName(){
 return $this->service_detail_name;
}
public function SetServiceDetailName($service_detail_name){
 $this->service_detail_name = $service_detail_name;
}

public $service_detail_status;
public function GetServiceDetailStatus(){
 return $this->service_detail_status;
}
public function SetServiceDetailStatus($service_detail_status){
 $this->service_detail_status = $service_detail_status;
}

public $service_detail_value;
public function GetServiceDetailValue(){
 return $this->service_detail_value;
}
public function SetServiceDetailValue($service_detail_value){
 $this->service_detail_value = $service_detail_value;
}

public $service_id;
public function GetServiceId(){
 return $this->service_id;
}
public function SetServiceId($service_id){
 $this->service_id = $service_id;
}

public function __construct()
{

}
}
?>