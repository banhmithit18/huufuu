<?php 
    class contact_answer
    {
        public $contact_us_id;
        public function getContactUsId(){
         return $this->contact_us_id;
        }
        public function setContactUsId($contact_us_id){
         $this->contact_us_id = $contact_us_id;
        }

        public $contact_question_id;
        public function getContactQuestionId(){
         return $this->contact_question_id;
        }
        public function setContactQuestionId($contact_question_id){
         $this->contact_question_id = $contact_question_id;
        }

        public $contact_answer_content;
        public function getContactAnswerContent(){
         return $this->contact_answer_content;
        }
        public function setContactAnswerContent($contact_answer_content){
         $this->contact_answer_content = $contact_answer_content;
        }
    }

?>