<?php
class user
{
    public $user_address;
    public function GetUserAddress()
    {
        return $this->user_address;
    }
    public function SetUserAddress($user_address)
    {
        $this->user_address = $user_address;
    }

    public $user_age;
    public function GetUserAge()
    {
        return $this->user_age;
    }
    public function SetUserAge($user_age)
    {
        $this->user_age = $user_age;
    }

    public $user_email;
    public function GetUserEmail()
    {
        return $this->user_email;
    }
    public function SetUserEmail($user_email)
    {
        $this->user_email = $user_email;
    }

    public $user_gender;
    public function GetUserGender()
    {
        return $this->user_gender;
    }
    public function SetUserGender($user_gender)
    {
        $this->user_gender = $user_gender;
    }


    public $user_name;
    public function GetUserName()
    {
        return $this->user_name;
    }
    public function SetUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    public $user_phone;
    public function GetUserPhone()
    {
        return $this->user_phone;
    }
    public function SetUserPhone($user_phone)
    {
        $this->user_phone = $user_phone;
    }

    public $user_pwd;
    public function GetUserPwd()
    {
        return $this->user_pwd;
    }
    public function SetUserPwd($user_pwd)
    {
        $this->user_pwd = $user_pwd;
    }

    public $user_username;
    public function GetUserUsername()
    {
        return $this->user_username;
    }
    public function SetUserUsername($user_username)
    {
        $this->user_username = $user_username;
    }
    public $user_status;
    public function GetUserStatus()
    {
        return $this->user_status;
    }
    public function SetUserStatus($user_status)
    {
        $this->user_status = $user_status;
    }

    public $user_role;
    public function GetUserRole()
    {
        return $this->user_role;
    }
    public function SetUserRole($user_role)
    {
        $this->user_role = $user_role;
    }

    public function __construct()
    {
    }
}
