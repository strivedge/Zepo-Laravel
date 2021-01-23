<?php

namespace Custom\Offer\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'title',
        'desc',
        'image',
        'start_date',
        'end_date',
        'status',
    ];

    protected $typeInstance;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_offers';

	 public function getAll()
    {
        $this->where(['id' => 2]);

        return $this;
    }
}