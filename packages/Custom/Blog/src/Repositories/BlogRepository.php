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
    
    // function for Homepage front end
    public function all()
    {
        return Blog::orderby('id', 'desc')->take(4)->get();
    }
    
    // function for Admin side
    public function create(array $data)
    {
        $blog = Blog::create($data);
        return $blog;
    }

    public function getAll()
    {
        return Blog::orderby('id', 'desc')->get();
    }

    public function findById($id)
    {
        return Blog::where('id', $id)->firstOrFail();
    }

    public function update(array $data, $id)
    {
        $blog = Blog::find($id);
        $blog->update($data);
        return $blog;
    }

    public function deleteData($id)
    {
        $blog = Blog::find($id)->delete();
        return $blog;
    }

    public function massDataDelete($ids)
    {
        foreach($ids as $id)
        {
            $blog = $this->findById($id);
            $blog->delete($blog);
        }
        return $blog;
    }
}