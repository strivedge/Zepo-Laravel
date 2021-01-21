<?php

namespace Custom\Testinominal\Repositories;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Container\Container as App;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Custom\Testinominal\Models\Testinominal;

class TestinominalRepository
{
    public function all()
    {
        return Testinominal::orderby('id', 'desc')->take(12)->get();
    }

    public function findById($testinominalId)
    {
        return Blog::where('id', $testinominalId)->firstOrFail();
    }  
}