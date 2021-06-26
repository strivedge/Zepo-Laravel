<?php

namespace Webkul\Core\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Core\Repositories\OfferGallaryRepository;
use File;
// use Validator;

class OfferGallaryController extends Controller
{
    protected $_config;

    protected $offerGallaryRepository;

    public function __construct(OfferGallaryRepository $offerGallaryRepository)
    {
        $this->offerGallaryRepository = $offerGallaryRepository;

        $this->_config = request('_config');
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function create()
    {
        return view($this->_config['view']);
    }

    public function store()
    {
    	$this->validate(request(), [
            'title'      => 'required',
            'image'    => 'required|mimes:bmp,png,svg,jpg,jpeg',
            'status'     => 'required',
        ]);

        $data = request()->all();

        $imageName = $data['image'];
    	// echo "<pre>"; print_r($imageName); exit();
        if($imageName != null)
        {
            $imageName1 = time().'.'.$imageName->extension();  
            $imageName->move(public_path('uploadImages/offerGallary'), $imageName1);
            $data['image'] = 'uploadImages/offerGallary/'.$imageName1;
        }

        $this->offerGallaryRepository->create($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Offer Gallary']));
        return redirect()->route($this->_config['redirect']);
    }

    public function edit($id)
    {
    	$offerGallary = $this->offerGallaryRepository->find($id);
        return view($this->_config['view'], compact('offerGallary'));
    }

    public function update($id)
    {
        $this->validate(request(), [
            'title' => 'required',
            'image' => 'nullable|mimes:bmp,png,svg,jpg,jpeg',
            'status' => 'required',
        ]);

    	$data = request()->all();

    	$old_data = $this->offerGallaryRepository->find($id);

    	if (request()->hasFile('image'))
        {
            $imageName = $data['image'];
            if (isset($old_data['image']) && !empty($old_data['image'])) {
                $file_path = public_path().'/'.$old_data['image'];
                if(File::exists($file_path)) 
                {
                    unlink($file_path);
                }
            }
            
            $imageName1 = time().'.'.$imageName->extension();  
            $imageName->move(public_path('uploadImages/offerGallary'), $imageName1);
            $data['image'] = 'uploadImages/offerGallary/'.$imageName1;
        }

        $this->offerGallaryRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Offer Gallary']));
        return redirect()->route($this->_config['redirect']);
    }

    public function destroy($id)
    {
    	$this->offerGallaryRepository->deleteData($id);
    	session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Offer Gallary']));
    }

    public function massDestroy()
    {
        $ids = explode(',', request()->input('indexes'));

        if ($ids != null) 
        {
            $this->offerGallaryRepository->massDataDelete($ids);
            session()->flash('success', trans('admin::app.settings.offer-gallary.mass-destroy-success'));
        }
        return redirect()->back();
    }

    public function massUpdate()
    {
        $ids = explode(',', request()->input('indexes'));
        $updateOption = request()->input('update-options');

        if ($ids != null && $updateOption != null) 
        {
            $this->offerGallaryRepository->massDataUpdate($ids, $updateOption);
            session()->flash('success', trans('admin::app.settings.offer-gallary.mass-update-success'));
        }
        return redirect()->back();
    }
}
