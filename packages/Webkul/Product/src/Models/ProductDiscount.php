<?php

namespace Webkul\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $table = 'master_product_discount';

    protected $fillable = [
    	'discount_type',
        'percentage',
        'discount_condition',
        'discount_qty',
        'discount_purchase',
        'discount_by',
    ];

    protected $typeInstance;
}
