<?php
class faq
{
    public $faq_answer;
    public function GetFaqAnswer()
    {
        return $this->faq_answer;
    }
    public function SetFaqAnswer($faq_answer)
    {
        $this->faq_answer = $faq_answer;
    }

    public $faq_priority;
    public function GetFaqpriority()
    {
        return $this->faq_priority;
    }
    public function SetFaqpriority($faq_priority)
    {
        $this->faq_priority = $faq_priority;
    }

    public $faq_question;
    public function GetFaqQuestion()
    {
        return $this->faq_question;
    }
    public function SetFaqQuestion($faq_question)
    {
        $this->faq_question = $faq_question;
    }

    public $faq_status;
    public function GetFaqStatus()
    {
        return $this->faq_status;
    }
    public function SetFaqStatus($faq_status)
    {
        $this->faq_status = $faq_status;
    }

    public function __construct()
    {
    }
}
