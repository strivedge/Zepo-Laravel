<?php

namespace Webkul\Product\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPrice extends Model
{
    protected $table = 'customer_product_price';

    protected $fillable = [
    	'product_id',
        'customer_id',
        'price',
    ];

    protected $typeInstance;
}
