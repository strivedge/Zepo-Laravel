<?php

namespace ACME\RazorPay\Models;

use Illuminate\Database\Eloquent\Model;

class Razorpay extends Model
{
    protected $table = 'order_transaction';

	protected $fillable = [
        'order_id',
        'cart_id',
        'payment_id',
        'transaction_payment_id',
        'is_guest',
        'customer_first_name',
        'customer_last_name',
        'customer_email',
        'customer_contact',
        'customer_id',
        'sub_total',
        'grand_total',
        'amount',
        'amount_captured',
        'payment_method',
        'pay_method',
        'currency',
        'payment_status',
        'payment_error',
        'date'
    ];

    protected $typeInstance;
     /**
     * The table associated with the model.
     *
     * @var string
     */

	public function getAll()
    {
        $this->where(['id' => 2]);

        return $this;
    }
}
