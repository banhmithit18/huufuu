<?php
class about_us
{
    public $about_us_path;
    public function GetAboutUsPath()
    {
        return $this->about_us_path;
    }
    public function SetAboutUsPath($about_us_path)
    {
        $this->about_us_path = $about_us_path;
    }

    public function __construct()
    {
    }
}
