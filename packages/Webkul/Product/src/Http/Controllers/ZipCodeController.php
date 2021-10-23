<?php

namespace Webkul\Product\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Product\Models\ZipCode;
use Webkul\Product\Repositories\ZipCodeRepository;
//use Validator;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Validator;
use Excel;
use Webkul\Admin\Imports\DataGridImport;

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
    public function import()
    {

        $valid_extension = ['xlsx', 'csv', 'xls'];

        if (! in_array(request()->file('file')->getClientOriginalExtension(), $valid_extension)) {
            session()->flash('error', trans('admin::app.export.upload-error'));
        } else {
            try {
                $excelData = (new DataGridImport)->toArray(request()->file('file'));
    
                foreach ($excelData as $data) {
                    foreach ($data as $column => $uploadData) {


                        $validator = Validator::make($uploadData, [
                            'area_name' => 'required',
                            'zipcode'      => 'required|Numeric|digits_between:6,10',
                           
                        ]);

                        if ($validator->fails()) {
                            $failedRules[$column+1] = $validator->errors();
                        }

                        $identiFier[$column+1] = $uploadData['zipcode'];
                    }

                    $identiFierCount = array_count_values($identiFier);

                    $filtered = array_filter($identiFier, function ($value) use ($identiFierCount) {
                        return $identiFierCount[$value] > 1;
                    });
                }

                if ($filtered) {
                
                    foreach ($filtered as $position => $identifier) {
                        $message[] = trans('admin::app.export.duplicate-error', ['zipcode' => $identifier, 'area_name' => $position]);
                    }

                    $finalMsg = implode(" ", $message);

                    session()->flash('error', $finalMsg);
                } else {
                    $errorMsg = [];

                    if (isset($failedRules)) {
                        foreach ($failedRules as $coulmn => $fail) {
                            if ($fail->first('area_name')){
                                $errorMsg[$coulmn] = $fail->first('area_name');
                            } elseif ($fail->first('zipcode')) {
                                $errorMsg[$coulmn] = $fail->first('zipcode');
                            } 
                        }

                        foreach ($errorMsg as $key => $msg) {
                            $msg = str_replace(".", "", $msg);
                            $message[] = $msg. ' at Row '  .$key . '.';
                        }

                        $finalMsg = implode(" ", $message);

                        session()->flash('error', $finalMsg);
                    } else {
                        $zipcodeRate = $this->zipCodeRepository->get()->toArray();

                        foreach ($zipcodeRate as $zipcode) {
                            $zipcodeIdentifier[$zipcode['id']] = $zipcode['zipcode'];
                        }

                        foreach ($excelData as $data) {
                            foreach ($data as $column => $uploadData) {
        

                                if (isset($zipcodeIdentifier)) {
                                    $id = array_search($uploadData['zipcode'], $zipcodeIdentifier);
                                    
                                    if ($id) {
                                        $this->zipCodeRepository->update($uploadData, $id);
                                    } else {
                                        $this->zipCodeRepository->create($uploadData);
                                    }
                                } else {
                                    $this->zipCodeRepository->create($uploadData);
                                }
                            }
                        }

                        session()->flash('success', trans('admin::app.response.upload-success', ['name' => 'Zipcode']));
                    }
                }
            } catch (\Exception $e) {
                report($e);
                $failure = new Failure(1, 'rows', [0 => trans('admin::app.export.enough-row-error')]);

                session()->flash('error', $failure->errors()[0]);
            }
        }
        return redirect()->route($this->_config['redirect']);
    }
}
