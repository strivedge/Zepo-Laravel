<?php

namespace Webkul\Velocity\Models;

use Illuminate\Database\Eloquent\Model;

class TabSection extends Model
{
	protected $fillable = [
        'category_id',
    ];

    protected $table = 'master_tabsection';
}
