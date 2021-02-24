<?php

namespace Custom\Festival\Models;

use Illuminate\Database\Eloquent\Model;

class FestivalProduct extends Model
{
    protected $fillable = [
        'parent_id',
        'product_id'
    ];

    protected $typeInstance;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_festival_products';

	public function getAll($id)
    {
        $this->where(['parent_id' => $id]);

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