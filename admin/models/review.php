<?php
class review
{
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

    public $review_comment;
    public function GetReviewComment()
    {
        return $this->review_comment;
    }
    public function SetReviewComment($review_comment)
    {
        $this->review_comment = $review_comment;
    }

    public $review_star;
    public function GetReviewStar()
    {
        return $this->review_star;
    }
    public function SetReviewStar($review_star)
    {
        $this->review_star = $review_star;
    }

    public $review_status;
    public function GetReviewStatus()
    {
        return $this->review_status;
    }
    public function SetReviewStatus($review_status)
    {
        $this->review_status = $review_status;
    }

    public $review_time;
    public function GetReviewTime()
    {
        return $this->review_time;
    }
    public function SetReviewTime($review_time)
    {
        $this->review_time = $review_time;
    }

    public function __construct()
    {
    }
}
