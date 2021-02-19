<?php

namespace ACME\Zepo\Repositories;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Container\Container as App;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ACME\Zepo\Models\SupportTicket;

class SupportTicketRepository
{
    // function for Front-End side
    public function create(array $data)
    {
        // echo "<pre>"; print_r($data); exit();
        $supportTicket = SupportTicket::create($data);
        return $supportTicket;
    }
}