<?php
class category
{

    public $category_name;
    public function GetCategoryName()
    {
        return $this->category_name;
    }
    public function SetCategoryName($category_name)
    {
        $this->category_name = $category_name;
    }

    public $category_status;
    public function GetCategoryStatus()
    {
        return $this->category_status;
    }
    public function SetCategoryStatus($category_status)
    {
        $this->category_status = $category_status;
    }

    public function __construct()
    {
    }
}
