<?php

namespace Custom\Festival\Repositories;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Container\Container as App;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Custom\Festival\Models\Festival;
use Custom\Festival\Models\FestivalProduct;

class FestivalRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
     function model()
    {
        return Festival::class;
    }


    // function for Homepage front end only data one row for active Festival
    public function all()
    {
        $currentDate = date("Y-m-d");
        return Festival::where('start_date', '<=', $currentDate)->where('end_date', '>', $currentDate)->where('status', '1')->orderby('id')->take(1)->get();
    }

    // function for Admin side
    public function create(array $data)
    {
        $festival = Festival::create($data);

        $festival->up_sells()->sync($data['up_sell'] ?? []);
        return $festival;
    }

    public function createProduct(array $data)
    {
        $FestivalProduct = FestivalProduct::create($data);
        return $FestivalProduct;
    }

    public function getAll()
    {
        return Festival::orderby('id')->get();
    }

    public function findById($id)
    {
        return Festival::where('id', $id)->firstOrFail();
    }

    public function update(array $data, $id)
    {
        $festival = Festival::find($id);
        $festival->update($data);

        $festival->up_sells()->sync($data['up_sell'] ?? []);

        return $festival;
    }

    public function updateStatus($id){

        $Festival = Festival::where('id','!=',$id)->update(['status'=>0]);
        return $Festival;

    }

    public function deleteData($id)
    {
        $Festival = Festival::find($id)->delete();

        $FestivalProduct = FestivalProduct::where('parent_id', $id)->delete();

        return $Festival;
    }

    public function deleteFesivalProduct($id)
    {
        $FestivalProduct = FestivalProduct::where('parent_id', $id)->delete();
        return $FestivalProduct;
    }

    public function massDataDelete($ids)
    {
        foreach($ids as $id)
        {
            $Festival = $this->findById($id);
            $Festival->delete($Festival);
        }
        return $Festival;
    }

    public function massDataUpdate($ids, $updateOption)
    {
        foreach($ids as $id)
        {
            $Festival = $this->findById($id);
            $Festival->update(['status' => $updateOption]);
        }
        return $Festival;
    }

    public function getFestivalProducts($id)
    {
        $products = DB::table('master_festival')
                   ->leftJoin('master_festival_products', 'master_festival.id', 'master_festival_products.parent_id')
                   ->leftJoin('products', 'products.id', 'master_festival_products.product_id')
                   ->where('master_festival.id', $id)
                   //->where('product_flat.channel', core()->getCurrentChannelCode())
                   //->where('product_flat.locale', app()->getLocale())
                   ->get();


        return $products;
    }

    public function getAllFestivalProducts()
    {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

          $results = DB::table('master_festival')
                ->leftJoin('master_festival_products', 'master_festival.id', 'master_festival_products.parent_id')
                ->leftJoin('product_flat', 'product_flat.product_id', 'master_festival_products.product_id')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->where('master_festival.start_date', '>=', $this->startDate)
                //->where('master_festival.end_date', '<=', $this->endDate)
                //->where('master_festival.end_date', '>=', \DB::raw('NOW()'))
                ->whereNotNull('product_flat.url_key')
                //->groupBy('catalog_rule_product_prices.product_id');
                ->get();
        return $results;
    }

}