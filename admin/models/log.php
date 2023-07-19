<?php
class log
{
    public $log_detail;
    public function GetLogDetail()
    {
        return $this->log_detail;
    }
    public function SetLogDetail($log_detail)
    {
        $this->log_detail = $log_detail;
    }
    
    public $log_name;
    public function GetLogName()
    {
        return $this->log_name;
    }
    public function SetLogName($log_name)
    {
        $this->log_name = $log_name;
    }

    public $log_time;
    public function GetLogTime()
    {
        return $this->log_time;
    }
    public function SetLogTime($log_time)
    {
        $this->log_time = $log_time;
    }

    public $user_id;
    public function GetUserId()
    {
        return $this->user_id;
    }
    public function SetUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function __construct()
    {
    }
}
