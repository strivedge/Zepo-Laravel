<?php

namespace Webkul\Product\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Product\Repositories\DiscountRepository;
use Validator;

class DiscountController extends Controller
{
    private $discountRepository;
    public function __construct(DiscountRepository $discountRepository)
    {
        $this->middleware('admin');
        $this->_config = request('_config');
        $this->discountRepository = $discountRepository;
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function create()
    {
        return view($this->_config['view']);
    }

    public function store(Request $request)
    {
        $data = request()->all();

        $this->validate(request(), [
            'percentage' => 'required',
            'discount_condition' => 'required',
            'discount_qty' => 'nullable|integer',
            'status' => 'required',
        ]);

        $this->discountRepository->create($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Discount']));

        return redirect()->route($this->_config['redirect']);
    }

    public function edit($id)
    {
    	$discount = $this->discountRepository->findById($id);
        return view($this->_config['view'], compact('discount'));
    }

    public function update(Request $request, $id)
    {
        $data = request()->all();

        $this->validate(request(), [
            'percentage' => 'required',
            'discount_condition' => 'required',
            'discount_qty' => 'nullable|integer',
            'status' => 'required',
        ]);

        $this->discountRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Discount']));

        return redirect()->route($this->_config['redirect']);
    }

    public function destroy($id)
    {
        $this->discountRepository->deleteData($id);
        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'ZipCode']));
    }

    public function massDestroy()
    {
        $ids = explode(',', request()->input('indexes'));

        if ($ids != null) 
        {
            $this->discountRepository->massDataDelete($ids);
            session()->flash('success', trans('admin::app.catalog.discounts.mass-destroy-success'));
        }
        return redirect()->back();
    }

    public function massUpdate()
    {
        $ids = explode(',', request()->input('indexes'));
        $updateOption = request()->input('update-options');

        if ($ids != null && $updateOption != null) 
        {
            $this->discountRepository->massDataUpdate($ids, $updateOption);
            session()->flash('success', trans('admin::app.catalog.discounts.mass-update-success'));
        }
        return redirect()->back();
    }
}
