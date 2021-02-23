<?php

namespace Custom\Festival\Models;

use Illuminate\Database\Eloquent\Model;

class Festival extends Model
{
    protected $fillable = [
        'title',
        'short_desc',
        'long_desc',
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
    protected $table = 'master_festival';

	public function getAll()
    {
        $this->where(['id' => 2]);

        return $this;
    }

    /**
     * The up sells that belong to the product.
     */
    public function up_sells()
    {
        return $this->belongsToMany(static::class, 'master_festival_products', 'parent_id', 'product_id')->limit(4);
    }

}