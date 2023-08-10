<?php
class feedback
{
    public $feedback_name;
    public function GetFeedbackName(){
     return $this->feedback_name;
    }
    public function SetFeedbackName($feedback_name){
     $this->feedback_name = $feedback_name;
    }

    public $feedback_content;
    public function GetFeedback_content(){
     return $this->feedback_content;
    }
    public function SetFeedback_content($feedback_content){
     $this->feedback_content = $feedback_content;
    }

    public $feedback_priority;
    public function GetFeedbackPriority(){
     return $this->feedback_priority;
    }
    public function SetFeedbackPriority($feedback_priority){
     $this->feedback_priority = $feedback_priority;
    }

    public $image_id;
    public function GetImageId(){
     return $this->image_id;
    }
    public function SetImageId($image_id){
     $this->image_id = $image_id;
    }
    
    public $feedback_status;
    public function GetFeedbackStatus(){
     return $this->feedback_status;
    }
    public function SetFeedbackStatus($feedback_status){
     $this->feedback_status = $feedback_status;
    }
    public function __construct()
    {
    
    }
}
