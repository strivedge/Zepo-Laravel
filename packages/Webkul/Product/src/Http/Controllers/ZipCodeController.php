<?php

namespace Webkul\Product\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Product\Models\ZipCode;
use Webkul\Product\Repositories\ZipCodeRepository;
use Validator;

class ZipCodeController extends Controller
{
    private $zipCodeRepository;
    public function __construct(ZipCodeRepository $zipCodeRepository)
    {
        $this->middleware('admin');
        $this->_config = request('_config');
        $this->zipCodeRepository = $zipCodeRepository;
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
            'area_name' => 'required',
            'zipcode'      => 'required|Numeric|digits_between:6,10|unique:master_zip_codes,zipcode',
        ]);

        $this->zipCodeRepository->create($data);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'ZipCode']));

        return redirect()->route($this->_config['redirect']);
    }

    public function edit($id)
    {
    	$zipcodes = $this->zipCodeRepository->findById($id);
        return view($this->_config['view'], compact('zipcodes'));
    }

    public function update(Request $request, $id)
    {
        $data = request()->all();

        $this->validate(request(), [
            'area_name' => 'required',
            'zipcode'      => 'required|Numeric|digits_between:6,10|unique:master_zip_codes,zipcode,'.$id,
        ]);

        $this->zipCodeRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'ZipCode']));

        return redirect()->route($this->_config['redirect']);
    }

    public function destroy($id)
    {
        $this->zipCodeRepository->deleteData($id);
        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'ZipCode']));
    }

    public function massDestroy()
    {
        $ids = explode(',', request()->input('indexes'));

        if ($ids != null) 
        {
            $this->zipCodeRepository->massDataDelete($ids);
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
            $this->zipCodeRepository->massDataUpdate($ids, $updateOption);
            session()->flash('success', trans('admin::app.catalog.zipcodes.status.mass-update-success'));
        }
        return redirect()->back();
    }
}
