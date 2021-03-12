<?php

namespace Custom\Offer\Repositories;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Container\Container as App;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Custom\Offer\Models\Offer;

class OfferRepository
{
    // function for Homepage front end only data one row for active offer
    public function all()
    {
        $currentDate = date("Y-m-d");
        return Offer::where('start_date', '<=', $currentDate)->where('end_date', '>', $currentDate)->where('status', '1')->orderby('id', 'desc')->take(1)->get();
    }

    public function getAllHome()
    {
        $currentDate = date("Y-m-d");
        return Offer::where('start_date', '<=', $currentDate)->where('end_date', '>', $currentDate)->where('status', '1')->orderby('id', 'desc')->get();
    }

    // function for Admin side
    public function create(array $data)
    {
        $offer = Offer::create($data);
        return $offer;
    }

    public function getAll()
    {
        return Offer::orderby('id', 'desc')->get();
    }

    public function findById($id)
    {
        return Offer::where('id', $id)->firstOrFail();
    }

    public function update(array $data, $id)
    {
        $offer = Offer::find($id);
        $offer->update($data);
        return $offer;
    }

    public function deleteData($id)
    {
        $offer = Offer::find($id)->delete();
        return $offer;
    }

    public function massDataDelete($ids)
    {
        foreach($ids as $id)
        {
            $offer = $this->findById($id);
            $offer->delete($offer);
        }
        return $offer;
    }

    public function massDataUpdate($ids, $updateOption)
    {
        foreach($ids as $id)
        {
            $offer = $this->findById($id);
            $offer->update(['status' => $updateOption]);
        }
        return $offer;
    }
}