<?php

namespace ACME\RazorPay\Payment;

use Webkul\Payment\Payment\Payment;

class RazorPay extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'razorpay';

    public function getRedirectUrl()
    {
        return "razorpay";
    }
}