<?php

namespace Webkul\Admin\Http\Controllers\Sales;

use Illuminate\Http\Request;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Sales\Repositories\CartProductRepository;

class CartProductController extends Controller
{
    protected $_config;
    protected $cartProductRepository;
    public function __construct(CartProductRepository $cartProductRepository)
    {
        $this->middleware('admin');
        $this->_config = request('_config');
        $this->cartProductRepository = $cartProductRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    public function massUpdate()
    {
        $ids = explode(',', request()->input('indexes'));
        $updateOption = request()->input('update-options');

        if ($ids != null && $updateOption != null) 
        {
            $this->cartProductRepository->massDataUpdate($ids, $updateOption);
            session()->flash('success', trans('admin::app.sales.cart-products.mass-update-success'));
        }
        return redirect()->back();
    }
}
