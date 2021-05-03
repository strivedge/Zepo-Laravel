<?php

namespace Webkul\Core\Repositories;

use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Event;
use Illuminate\Container\Container as App;

class OfferGallaryRepository extends Repository
{
	function model()
    {
        return 'Webkul\Core\Models\OfferGallary';
    }

    // front-end side
    public function getTwo()
    {
        $offerGallary = $this->model->where('status', 1)->orderby('id', 'desc')->take(2)->get();
        return $offerGallary;
    }

    // admin side
    public function create(array $data)
    {
        $offerGallary = $this->model->create($data);
        return $offerGallary;
    }

    public function update(array $data, $id)
    {
        $offerGallary = $this->model->find($id)->update($data);
        return $offerGallary;
    }

    public function deleteData($id)
    {
        $offerGallary = $this->model->find($id)->delete();
        return $offerGallary;
    }

    public function massDataDelete($ids)
    {
        foreach($ids as $id)
        {
            $offerGallary = $this->model->find($id)->delete();
        }
        return $offerGallary;
    }

    public function massDataUpdate($ids, $updateOption)
    {
        foreach($ids as $id)
        {
            $offerGallary = $this->model->find($id)->update(['status' => $updateOption]);
        }
        return $offerGallary;
    }
}