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

    // for front-end
    public function checkZip($zipcode, $status)
    {
        $zipcodes = $this->model->where('zipcode', $zipcode)->where('status', $status)->get();
        return $zipcodes;
    }

    // for admin side
    public function create(array $data)
    {
        $zipcodes = $this->model->create($data);
        return $zipcodes;
    }

    public function findById($id)
    {
        $zipcodes = $this->model->find($id);
        return $zipcodes;
    }

    public function update(array $data, $id)
    {
        $zipcodes = $this->model->find($id)->update($data);
        return $zipcodes;
    }

    public function deleteData($id)
    {
        $zipcodes = $this->model->find($id)->delete();
        return $zipcodes;
    }

    public function massDataDelete($ids)
    {
        foreach($ids as $id)
        {
            $zipcodes = $this->model->find($id)->delete();
        }
        return $zipcodes;
    }

    public function massDataUpdate($ids, $updateOption)
    {
        foreach($ids as $id)
        {
            $zipcodes = $this->model->find($id)->update(['status' => $updateOption]);
        }
        return $zipcodes;
    }
}