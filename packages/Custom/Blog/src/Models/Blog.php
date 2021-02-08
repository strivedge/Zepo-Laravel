<?php

namespace Custom\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'master_posts';

	protected $fillable = [
        'title',
        'image',
        'slug',
        'content',
        'date',
    ];

    protected $typeInstance;
     /**
     * The table associated with the model.
     *
     * @var string
     */

	public function getAll()
    {
        $this->where(['id' => 2]);

        return $this;
    }
}
