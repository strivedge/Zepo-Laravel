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
    public function all()
    {
        return Offer::orderby('id', 'desc')->take(1)->get();
    }

    public function findById($offerId)
    {
        return Offer::where('id', $offerId)->firstOrFail();
    }
}