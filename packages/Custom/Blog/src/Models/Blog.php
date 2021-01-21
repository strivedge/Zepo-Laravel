<?php

namespace Custom\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

	protected $fillable = [
        'title',
        'image',
        'content',
        'date',
    ];

    protected $typeInstance;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_posts';

	public function getAll()
    {
        $this->where(['id' => 2]);

        return $this;
    }
}
