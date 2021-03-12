<?php

namespace Webkul\Sales\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Eloquent\Repository;
use Webkul\Checkout\Models\Cart;

class CartProductRepository extends Repository
{
	function model()
    {
        return Cart::class;
    }

    public function findById($id)
    {
        return Cart::where('id', $id)->firstOrFail();
    }

    public function massDataUpdate($ids, $updateOption)
    {
        foreach($ids as $id)
        {
            $cart = $this->findById($id);
            $cart->update(['status' => $updateOption]);
        }
        return $cart;
    }
}