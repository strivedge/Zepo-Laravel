<?php

namespace Webkul\Product\Repositories;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Webkul\Product\Models\ProductDiscount;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;

class DiscountRepository extends Repository
{
    function model()
    {
        return 'Webkul\Product\Models\ProductDiscount';
    }

    // front-end product detail page
    public function getBasicDiscount() 
    {
        $discount = $this->model
            ->where('discount_type', 'Basic Discount')
            ->where('status', 1)
            ->orderby('id', 'desc')
            ->take(3)
            ->get();

        return $discount;
    }

    public function getExtraBulkDiscount() 
    {
        $discount = $this->model
            ->where('discount_type', 'Extra Bulk Discount')
            ->where('status', 1)
            ->orderby('id', 'desc')
            ->take(3)
            ->get();

        return $discount;
    }

    // for admin side
    public function create(array $data)
    {
        $discount = $this->model->create($data);
        return $discount;
    }

    public function findById($id)
    {
        $discount = $this->model->find($id);
        return $discount;
    }

    public function update(array $data, $id)
    {
        $discount = $this->model->find($id)->update($data);
        return $discount;
    }

    public function deleteData($id)
    {
        $discount = $this->model->find($id)->delete();
        return $discount;
    }

    public function massDataDelete($ids)
    {
        foreach($ids as $id)
        {
            $discount = $this->model->find($id)->delete();
        }
        return $discount;
    }

    public function massDataUpdate($ids, $updateOption)
    {
        foreach($ids as $id)
        {
            $discount = $this->model->find($id)->update(['status' => $updateOption]);
        }
        return $discount;
    }
}