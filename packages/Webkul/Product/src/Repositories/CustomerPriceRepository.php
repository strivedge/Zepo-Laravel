<?php

namespace Webkul\Product\Repositories;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Webkul\Product\Models\CustomerPrice;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;

class CustomerPriceRepository extends Repository
{
    function model()
    {
        return 'Webkul\Product\Models\CustomerPrice';
    }

    // for front-end
    public function checkIfExist($product_id,$customer_id)
    {
        $data = $this->model->where('product_id', $product_id)->where('customer_id', $customer_id)->first();
        return $data;
    }

    public function getDataByProduct($product_id)
    {
        $data = $this->model->where('product_id', $product_id)->get();
        return $data;
    }

    // for admin side
    public function create(array $data)
    {
        $data = $this->model->create($data);
        return $data;
    }

    public function findById($id)
    {
        $data = $this->model->find($id);
        return $data;
    }

    public function update(array $data, $id)
    {
        $data = $this->model->find($id)->update($data);
        return $data;
    }

    public function deleteData($product_id)
    {
        $data = $this->model->where('product_id', $product_id)->delete();
        return $data;
    }

    public function deleteDataByCustomer($product_id,$customer_ids)
    {
        $data = $this->model->where('product_id', $product_id)->whereNotIn('customer_id', $customer_ids)->delete();
        return $data;
    }

    public function massDataDelete($product_ids)
    {
        $data = $this->model->whereIn('product_id', $product_ids)->delete();
        return $data;
    }

   
}