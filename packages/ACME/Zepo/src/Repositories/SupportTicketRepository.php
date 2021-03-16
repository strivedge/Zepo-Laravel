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

    // functions for admin side
    public function findById($id)
    {
        return SupportTicket::where('id', $id)->firstOrFail();
    }

    public function update(array $data, $id)
    {
        $supportTicket = SupportTicket::find($id);
        $supportTicket->update($data);
        return $supportTicket;
    }

    public function deleteData($id)
    {
        $supportTicket = SupportTicket::find($id)->delete();
        return $supportTicket;
    }

     public function massDataDelete($ids)
    {
        foreach($ids as $id)
        {
            $supportTicket = $this->findById($id);
            $supportTicket->delete($supportTicket);
        }
        return $supportTicket;
    }

    public function massDataUpdate($ids, $updateOption)
    {
        foreach($ids as $id)
        {
            $supportTicket = $this->findById($id);
            $supportTicket->update(['status' => $updateOption]);
        }
        return $supportTicket;
    }
}