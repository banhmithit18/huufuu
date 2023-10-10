<?php 
class project_detail
{
    public function __construct()
    {
    
    }

    public $project_id;
    public function getProjectId(){
     return $this->project_id;
    }

    public function setProjectId($project_id){
     $this->project_id = $project_id;
    } 
    
    public $project_detail_text;
    public function getProjectDetailText(){
     return $this->project_detail_text;
    }
    public function setProjectDetailText($project_detail_text){
     $this->project_detail_text = $project_detail_text;
    }

    public $image_id;
    public function getImageId(){
     return $this->image_id;
    }
    public function setImageId($image_id){
     $this->image_id = $image_id;
    }

    public $project_detail_priority;
    public function getProjectDetailPriority(){
     return $this->project_detail_priority;
    }
    public function setProjectDetailPriority($project_detail_priority){
     $this->project_detail_priority = $project_detail_priority;
    }

    public $project_detail_isSameRow;
    public function getProjectDetailIsSameRow(){
     return $this->project_detail_isSameRow;
    }
    public function setProjectDetailIsSameRow($project_detail_isSameRow){
     $this->project_detail_isSameRow = $project_detail_isSameRow;
    }

    public $project_detail_status;
    public function getProjectDetailStatus(){
     return $this->project_detail_status;
    }
    public function setProjectDetailStatus($project_detail_status){
     $this->project_detail_status = $project_detail_status;
    }

    public $project_detail_type;
    public function getProjectDetailType(){
     return $this->project_detail_type;
    }
    public function setProjectDetailType($project_detail_type){
     $this->project_detail_type = $project_detail_type;
    }
}
