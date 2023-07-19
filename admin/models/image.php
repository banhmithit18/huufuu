<?php
class image
{
    public $image_path;
    public function GetImagePath()
    {
        return $this->image_path;
    }
    public function SetImagePath($image_path)
    {
        $this->image_path = $image_path;
    }

    public $image_status;
    public function GetImageStatus()
    {
        return $this->image_status;
    }
    public function SetImageStatus($image_status)
    {
        $this->image_status = $image_status;
    }

    public function __construct()
    {
    }
}
