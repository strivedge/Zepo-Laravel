<?php

namespace ACME\RazorPay\Repositories;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Container\Container as App;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ACME\RazorPay\Models\Razorpay;

class RazorpayRepository
{
    
    // function for Homepage front end
    public function all()
    {
        return Razorpay::orderby('id', 'desc')->take(4)->get();
    }

    public function findBySlug($slug)
    {
        return Razorpay::where('slug', $slug)->firstOrFail();
    }
    
    // function for Admin side
    public function create(array $data)
    {
        $tranData = Razorpay::create($data);
        return $tranData;
    }

    public function getAll()
    {
        return Razorpay::orderby('id', 'desc')->get();
    }

    public function findById($id)
    {
        return Razorpay::where('id', $id)->firstOrFail();
    }

    public function update(array $data, $id)
    {
        $trans = Razorpay::find($id);
        $trans->update($data);
        return $trans;
    }

    public function deleteData($id)
    {
        $trans = Razorpay::find($id)->delete();
        return $trans;
    }

    public function massDataDelete($ids)
    {
        foreach($ids as $id)
        {
            $trans = $this->findById($id);
            $trans->delete($trans);
        }
        return $trans;
    }
}