<?php
class contact_us
{

    public $contact_us_status;
    public function GetContactUsStatus()
    {
        return $this->contact_us_status;
    }
    public function SetContactUsStatus($contact_us_status)
    {
        $this->contact_us_status = $contact_us_status;
    }

    public $customer_id;
    public function GetCustomerId()
    {
        return $this->customer_id;
    }
    public function SetCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    public $contact_us_created_time;
    public function GetContactUsCreatedTime()
    {
        return $this->contact_us_created_time;
    }
    public function SetContactUsCreatedTime($contact_us_created_time)
    {
        $this->contact_us_created_time = $contact_us_created_time;
    }

    public function __construct()
    {
    }
}
