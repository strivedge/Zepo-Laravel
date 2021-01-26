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
    // function for Homepage front end only 12 rows data of testinominal
    public function all()
    {
        return Testinominal::orderby('id', 'desc')->take(12)->get();
    }

    // function for Admin side
    public function create(array $data)
    {
        $testinominal = Testinominal::create($data);
        return $testinominal;
    }

    public function getAll()
    {
        return Testinominal::orderby('id', 'desc')->get();
    }

    public function findById($id)
    {
        return Testinominal::where('id', $id)->firstOrFail();
    }

    public function update(array $data, $id)
    {
        $testinominal = Testinominal::find($id);
        $testinominal->update($data);
        return $testinominal;
    }

    public function deleteData($id)
    {
        $testinominal = Testinominal::find($id)->delete();
        return $testinominal;
    }

    public function massDataDelete($ids)
    {
        foreach($ids as $id)
        {
            $testinominal = $this->findById($id);
            $testinominal->delete($testinominal);
        }
        return $testinominal;
    }
}