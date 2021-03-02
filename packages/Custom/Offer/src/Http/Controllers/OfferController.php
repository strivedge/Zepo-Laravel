<?php

namespace Custom\Offer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Custom\Offer\Models\Offer;
use Custom\Offer\Repositories\OfferRepository;
use Illuminate\Foundation\Validation\ValidatesRequests;
use File;
use Validator;

class OfferController extends Controller
{
    use ValidatesRequests;
    protected $_config;
    private $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->middleware('admin');
        $this->_config = request('_config');
        $this->offerRepository = $offerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = $this->offerRepository->getAll();
        return view($this->_config['view'], compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->all();

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,bmp,png,gif',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) 
        {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors);
        }

        $imageName = $request->image;
        if($imageName != null)
        {
            $imageName1 = time().'.'.$imageName->extension();  
            $imageName->move(public_path('uploadImages/offer'), $imageName1);
            $data['image'] = 'uploadImages/offer/'.$imageName1;
        }

        $this->offerRepository->create($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Offer']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offers = $this->offerRepository->findById($id);
        return view($this->_config['view'], compact('offers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = request()->all();

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,bmp,png,gif',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
            
        if ($validator->fails()) 
        {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors);
        }
            
        $old_data = $this->offerRepository->findById($id);

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
            $imageName->move(public_path('uploadImages/offer'), $imageName1);
            $data['image'] = 'uploadImages/offer/'.$imageName1;
        }

        $this->offerRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Offer']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->offerRepository->deleteData($id);
        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Offer']));
        // return redirect()->route($this->_config['redirect']);
    }

    public function massDestroy()
    {
        $ids = explode(',', request()->input('indexes'));

        if ($ids != null) 
        {
            $this->offerRepository->massDataDelete($ids);
            session()->flash('success', trans('offer::app.offer.mass-destroy-success'));
        }
        return redirect()->back();
    }

    public function massUpdate()
    {
        $ids = explode(',', request()->input('indexes'));
        $updateOption = request()->input('update-options');

        if ($ids != null && $updateOption != null) 
        {
            $this->offerRepository->massDataUpdate($ids, $updateOption);
            session()->flash('success', trans('offer::app.offer.mass-update-success'));
        }
        return redirect()->back();
    }
}
