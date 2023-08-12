<?php
class project
{
    public $project_name;
    public function GetProjectName(){
     return $this->project_name;
    }
    public function SetProjectName($project_name){
     $this->project_name = $project_name;
    }

    public $project_content;
    public function GetProject_content(){
     return $this->project_content;
    }
    public function SetProject_content($project_content){
     $this->project_content = $project_content;
    }

    public $category_id;
    public function getCategoryId(){
     return $this->project_content;
    }
    public function setCategoryId($category_id){
     $this->category_id = $category_id;
    }

    public $image_id;
    public function GetImageId(){
     return $this->image_id;
    }
    public function SetImageId($image_id){
     $this->image_id = $image_id;
    }

    public $background_image_id;
    public function GetBackgroundImageId(){
     return $this->image_id;
    }
    public function SetBackgroundImageId($image_id){
     $this->image_id = $image_id;
    }
    
    public $project_status;
    public function GetProjectStatus(){
     return $this->project_status;
    }
    public function SetProjectStatus($project_status){
     $this->project_status = $project_status;
    }
    public function __construct()
    {
    
    }
}
