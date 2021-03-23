<?php

namespace Webkul\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    protected $table = 'master_zip_codes';

    protected $fillable = [
    	'area_name',
        'zipcode',
        'status',
    ];

    protected $typeInstance;
}
