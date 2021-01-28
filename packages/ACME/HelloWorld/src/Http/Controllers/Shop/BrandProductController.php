<?php

namespace ACME\HelloWorld\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BrandProductController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_config = request('_config');
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

    public function productByBrand($brand_name)
    {
        $brand = app('Webkul\Attribute\Repositories\AttributeRepository')->getAttributeOptionData($brand_name);
        //echo"<pre>";print_r($brand);exit();
        if (!empty($brand[0]->attribute_id) && $brand[0]->id) {
            $attribute_id = $brand[0]->attribute_id;
            $option_id = $brand[0]->id;

            $product = app('Webkul\Product\Repositories\ProductAttributeValueRepository')->findByBrandOption($attribute_id,$option_id);

             //echo"product<pre>";print_r($product);exit();
        }else{
            $product = [];
        }
        //echo"<pre>";print_r($brand[0]->attribute_id);exit();

        
        return view($this->_config['view'], compact('product'));
    }

}