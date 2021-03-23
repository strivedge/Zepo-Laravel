<?php

namespace Webkul\Product\Repositories;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Webkul\Product\Models\ZipCode;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;

class ZipCodeRepository extends Repository
{
    function model()
    {
        return 'Webkul\Product\Models\ZipCode';
    }
}