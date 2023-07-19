<?php
class customer
{
  public $customer_address;
  public function GetCustomerAddress()
  {
    return $this->customer_address;
  }
  public function SetCustomerAddress($customer_address)
  {
    $this->customer_address = $customer_address;
  }

  public $customer_age;
  public function GetCustomerAge()
  {
    return $this->customer_age;
  }
  public function SetCustomerAge($customer_age)
  {
    $this->customer_age = $customer_age;
  }

  public $customer_email;
  public function GetCustomerEmail()
  {
    return $this->customer_email;
  }
  public function SetCustomerEmail($customer_email)
  {
    $this->customer_email = $customer_email;
  }

  public $customer_gender;
  public function GetCustomerGender()
  {
    return $this->customer_gender;
  }
  public function SetCustomerGender($customer_gender)
  {
    $this->customer_gender = $customer_gender;
  }



  public $customer_name;
  public function GetCustomerName()
  {
    return $this->customer_name;
  }
  public function SetCustomerName($customer_name)
  {
    $this->customer_name = $customer_name;
  }

  public $customer_phone;
  public function GetCustomerPhone()
  {
    return $this->customer_phone;
  }
  public function SetCustomerPhone($customer_phone)
  {
    $this->customer_phone = $customer_phone;
  }

  public function __construct()
  {
  }
}
