<?php
class service_image
{
  

    public $service_id;
    public function GetServiceId(){
     return $this->service_id;
    }
    public function SetServiceId($service_id){
     $this->service_id = $service_id;
    }

    public $image_id;
    public function GetImageId(){
     return $this->image_id;
    }
    public function SetImageId($image_id){
     $this->image_id = $image_id;
    }

    public function __construct()
    {
    
    }
}
?>