<?php

namespace Webkul\Core\Models;

use Illuminate\Database\Eloquent\Model;

class OfferGallary extends Model
{
    protected $table = 'master_offer_gallary';

    protected $fillable = [
        'title',
        'image',
        'status',
    ];
}
