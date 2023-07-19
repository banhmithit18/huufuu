<?php
class blog
{
    public $blog_content_path;
    public function GetBlogContent()
    {
        return $this->blog_content_path;
    }
    public function SetBlogContent($blog_content_path)
    {
        $this->blog_content_path = $blog_content_path;
    }



    public $blog_priority;
    public function GetBlogpriority()
    {
        return $this->blog_priority;
    }
    public function SetBlogpriority($blog_priority)
    {
        $this->blog_priority = $blog_priority;
    }

    public $blog_status;
    public function GetBlogStatus()
    {
        return $this->blog_status;
    }
    public function SetBlogStatus($blog_status)
    {
        $this->blog_status = $blog_status;
    }

    public $blog_title;
    public function GetBlogTitle()
    {
        return $this->blog_title;
    }
    public function SetBlogTitle($blog_title)
    {
        $this->blog_title = $blog_title;
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
