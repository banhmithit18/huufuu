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

    public $image_id;
    public function GetImageId(){
     return $this->image_id;
    }
    public function SetImageId($image_id){
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