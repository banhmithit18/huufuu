<?php
class contact_us
{


    public $contact_us_message;
    public function GetContactUsMessage()
    {
        return $this->contact_us_message;
    }
    public function SetContactUsMessage($contact_us_message)
    {
        $this->contact_us_message = $contact_us_message;
    }

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

    public $service_id;
    public function GetServiceId()
    {
        return $this->service_id;
    }
    public function SetServiceId($service_id)
    {
        $this->service_id = $service_id;
    }

 

    public function __construct()
    {
    }
}
