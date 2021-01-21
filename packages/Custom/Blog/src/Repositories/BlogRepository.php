<?php

namespace Custom\Blog\Repositories;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Container\Container as App;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Custom\Blog\Models\Blog;

class BlogRepository
{
    public function all()
    {
        return Blog::all();
    }

    public function findById($blogId)
    {
        return Blog::where('id', $blogId)->firstOrFail();
    }
}