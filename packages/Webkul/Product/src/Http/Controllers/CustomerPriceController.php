<?php

namespace Webkul\Product\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Product\Models\CustomerPrice;
use Webkul\Product\Repositories\CustomerPriceRepository;
use Webkul\Product\Repositories\ProductRepository;
use Validator;
use Illuminate\Support\Facades\DB;

class CustomerPriceController extends Controller
{

    protected $productRepository;

    private $customerPriceRepository;

    public function __construct(ProductRepository $productRepository,CustomerPriceRepository $customerPriceRepository)
    {
        $this->middleware('admin');
        $this->_config = request('_config');
        $this->productRepository = $productRepository;
        $this->customerPriceRepository = $customerPriceRepository;

      
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function create()
    {
        
         $queryBuilder = DB::table('product_flat')
            ->leftJoin('products', 'product_flat.product_id', '=', 'products.id')
            ->where('product_flat.name','!=', '')
            ->select(
                'product_flat.locale',
                'product_flat.channel',
                'product_flat.product_id',
                'products.sku as product_sku',
                'product_flat.name as product_name',
                'product_flat.status',
                'product_flat.price'
        );

        if(auth()->guard('admin')->user()->role->id != 1)
        {
            $queryBuilder->where('products.seller_id', auth()->guard('admin')->id());
        }

        $queryBuilder->groupBy('product_flat.product_id', 'product_flat.channel');

        $products = $queryBuilder->get();

        //echo"<pre>";print_r($products);exit();

        $customers = DB::table('customers')
            ->leftJoin('customer_groups', 'customers.customer_group_id', '=', 'customer_groups.id')
            ->addSelect('customers.id as customer_id', 'customers.email', 'customer_groups.name', 'customers.phone', 'customers.gender', 'status')
            ->addSelect(DB::raw('CONCAT(' . DB::getTablePrefix() . 'customers.first_name, " ", ' . DB::getTablePrefix() . 'customers.last_name) as full_name'))
            ->get();

        return view($this->_config['view'], compact('products','customers'));
    }

    public function store(Request $request)
    {
        $data = request()->all();

        //echo"<pre>";print_r($data);//exit();

        // $this->validate(request(), [
        //     'product_id'      => 'required',
        //     'customer_id'      => 'required',
        //     'price' => 'required'
        // ]);

        $cust = [];
        foreach ($data['customer_id'] as $k => $val) {
            array_push($cust, $val);
            $checkIfExist = $this->customerPriceRepository->checkIfExist($data['product_id'],$val);
            //echo"<pre>"; print_r($checkIfExist);exit();

            $arr = ['product_id'=>$data['product_id'],'customer_id'=>$val,'price'=>$data['customer_price'][$k]];

            if (isset($checkIfExist) && !empty($checkIfExist)) {
                $this->customerPriceRepository->update($arr,$checkIfExist->id);
            }else{
                $this->customerPriceRepository->create($arr);
            }
            //array_push($insertData, $arr);
        }
        //echo"<pre>";print_r($cust);exit();
        if(count($cust) > 0){
            $this->customerPriceRepository->deleteDataByCustomer($data['product_id'],$cust);
        }
        

        //echo"<pre>";print_r($insertData);exit();

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'CustomerPrice']));

        return redirect()->route($this->_config['redirect']);
    }

    public function edit($product_id)
    {
    	$data = $this->customerPriceRepository->getDataByProduct($product_id);

        //echo"<pre>";print_r($data);exit();
        $queryBuilder = DB::table('product_flat')
            ->leftJoin('products', 'product_flat.product_id', '=', 'products.id')
            ->where('product_flat.name','!=', '')
            ->select(
                'product_flat.locale',
                'product_flat.channel',
                'product_flat.product_id',
                'products.sku as product_sku',
                'product_flat.name as product_name',
                'product_flat.status',
                'product_flat.price'
        );

        if(auth()->guard('admin')->user()->role->id != 1)
        {
            $queryBuilder->where('products.seller_id', auth()->guard('admin')->id());
        }

        $queryBuilder->groupBy('product_flat.product_id', 'product_flat.channel');

        $products = $queryBuilder->get();

        $customers = DB::table('customers')
            ->leftJoin('customer_groups', 'customers.customer_group_id', '=', 'customer_groups.id')
            ->addSelect('customers.id as customer_id', 'customers.email', 'customer_groups.name', 'customers.phone', 'customers.gender', 'status')
            ->addSelect(DB::raw('CONCAT(' . DB::getTablePrefix() . 'customers.first_name, " ", ' . DB::getTablePrefix() . 'customers.last_name) as full_name'))
            ->get();

        //$data = DB::table('customer_product_price')->where('product_id', $product_id)->get();
        return view($this->_config['view'], compact('product_id','data','products','customers'));
    }

    public function update(Request $request, $id)
    {
        $data = request()->all();

        $this->validate(request(), [
            'product_id'      => 'required',
            'customer_id'      => 'required',
             'price' => 'required'
        ]);

        $this->customerPriceRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'CustomerPrice']));

        return redirect()->route($this->_config['redirect']);
    }

    public function destroy($id)
    {
        //echo"<pre>";print_r($id);exit();
        $this->customerPriceRepository->deleteData($id);
        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Customer Price']));
        return redirect()->back();
    }

    public function massDestroy()
    {
        $ids = explode(',', request()->input('indexes'));
        //echo"<pre>";print_r($ids);exit();
        if (count($ids) > 0) 
        {
            $this->customerPriceRepository->massDataDelete($ids);
            session()->flash('success', trans('admin::app.catalog.zipcodes.status.mass-destroy-success'));
        }
        return redirect()->back();
    }

    public function massUpdate()
    {
        $ids = explode(',', request()->input('indexes'));
        $updateOption = request()->input('update-options');

        if ($ids != null && $updateOption != null) 
        {
            $this->customerPriceRepository->massDataUpdate($ids, $updateOption);
            session()->flash('success', trans('admin::app.catalog.zipcodes.status.mass-update-success'));
        }
        return redirect()->back();
    }
}
