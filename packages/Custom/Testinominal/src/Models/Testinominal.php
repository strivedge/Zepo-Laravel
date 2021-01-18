<?php

namespace Custom\Testinominal\Models;

use Illuminate\Database\Eloquent\Model;

class Testinominal extends Model
{

	protected $fillable = [
        'title',
        'image',
        'desc',
        'date',
    ];

    protected $typeInstance;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_testinominal';

	 public function getAll()
    {
        $this->where(['id' => 2]);

        return $this;
    }
}
