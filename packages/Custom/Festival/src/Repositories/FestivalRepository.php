<?php

namespace Custom\Festival\Repositories;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Container\Container as App;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Custom\Festival\Models\Festival;

class FestivalRepository
{
    // function for Homepage front end only data one row for active Festival
    public function all()
    {
        $currentDate = date("Y-m-d");
        return Festival::where('start_date', '<=', $currentDate)->where('end_date', '>', $currentDate)->where('status', '1')->orderby('id', 'desc')->take(1)->get();;
    }

    // function for Admin side
    public function create(array $data)
    {
        $Festival = Festival::create($data);
        return $Festival;
    }

    public function getAll()
    {
        return Festival::orderby('id', 'desc')->get();
    }

    public function findById($id)
    {
        return Festival::where('id', $id)->firstOrFail();
    }

    public function update(array $data, $id)
    {
        $Festival = Festival::find($id);
        $Festival->update($data);
        return $Festival;
    }

    public function deleteData($id)
    {
        $Festival = Festival::find($id)->delete();
        return $Festival;
    }

    public function massDataDelete($ids)
    {
        foreach($ids as $id)
        {
            $Festival = $this->findById($id);
            $Festival->delete($Festival);
        }
        return $Festival;
    }

    public function massDataUpdate($ids, $updateOption)
    {
        foreach($ids as $id)
        {
            $Festival = $this->findById($id);
            $Festival->update(['status' => $updateOption]);
        }
        return $Festival;
    }
}