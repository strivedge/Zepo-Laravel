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
        return Offer::where('status', '0')->orderby('id', 'desc')->take(1)->get();
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
}