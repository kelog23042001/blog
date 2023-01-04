<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CategoryService
{
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }
    public function sendCouponMail()
    {
        
    }
    public function updateStatusShipment()
    {
    }
}
