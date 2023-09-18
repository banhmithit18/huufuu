<?php 
    class contact_question
    {
        
        public $contact_question_content;
        public function getContactQuestionContent(){
         return $this->contact_question_content;
        }
        public function setContactQuestionContent($contact_question_content){
         $this->contact_question_content = $contact_question_content;
        }

        public $contact_question_priority;
        public function getContactQuestionPriority(){
         return $this->contact_question_priority;
        }
        public function setContactQuestionPriority($contact_question_priority){
         $this->contact_question_priority = $contact_question_priority;
        }      
        
        public $contact_question_status;
        public function getContactQuestionStatus(){
         return $this->contact_question_status;
        }
        public function setContactQuestionStatus($contact_question_status){
         $this->contact_question_status = $contact_question_status;
        }

        public $contact_question_required;
        public function getContractQuestionRequired(){
         return $this->contact_question_required;
        }
        public function setContractQuestionRequired($contact_question_required){
         $this->contact_question_required = $contact_question_required;
        }           

    }
?>