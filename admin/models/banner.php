<?php
class banner
{


    public $banner_content;
    public function GetBannerContent()
    {
        return $this->banner_content;
    }
    public function SetBannerContent($banner_content)
    {
        $this->banner_content = $banner_content;
    }

    public $banner_link;
    public function GetBannerLink()
    {
        return $this->banner_link;
    }
    public function SetBannerLink($banner_link)
    {
        $this->banner_link = $banner_link;
    }

    public $banner_priority;
    public function GetBannerpriority()
    {
        return $this->banner_priority;
    }
    public function SetBannerpriority($banner_priority)
    {
        $this->banner_priority = $banner_priority;
    }

    public $banner_status;
    public function GetBannerStatus()
    {
        return $this->banner_status;
    }
    public function SetBannerStatus($banner_status)
    {
        $this->banner_status = $banner_status;
    }

    public $banner_title;
    public function GetBannerTitle()
    {
        return $this->banner_title;
    }
    public function SetBannerTitle($banner_title)
    {
        $this->banner_title = $banner_title;
    }

    public $banner_type;
    public function GetBannerType()
    {
        return $this->banner_type;
    }
    public function SetBannerType($banner_type)
    {
        $this->banner_type = $banner_type;
    }

    public $image_id;
    public function GetImageId()
    {
        return $this->image_id;
    }
    public function SetImageId($image_id)
    {
        $this->image_id = $image_id;
    }

    public function __construct()
    {
    }
}
