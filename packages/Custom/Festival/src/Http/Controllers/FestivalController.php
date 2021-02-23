<?php

namespace Custom\Festival\Http\Controllers;

use Illuminate\Http\Request;
use Custom\Festival\Repositories\FestivalRepository;
use File;

class FestivalController extends Controller
{
    protected $_config;
    private $feastivalRepository;

    public function __construct(FestivalRepository $feastivalRepository)
    {
        $this->middleware('admin');
        $this->_config = request('_config');
        $this->feastivalRepository = $feastivalRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feastival = $this->feastivalRepository->getAll();

        //print_r($this->_config['view']);exit();
        return view($this->_config['view'], compact('feastival'));
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
        $this->validate($request, [
            'title' => 'required',
            'desc' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $imageName = $request->image;
        if($imageName != null)
        {
            $imageName1 = time().'.'.$imageName->extension();  
            $imageName->move(public_path('uploadImages/feastival'), $imageName1);
            $data['image'] = $imageName1;
        }

        $this->feastivalRepository->create($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Feastival']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feastival  $feastival
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feastival  $feastival
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feastival = $this->feastivalRepository->findById($id);
        return view($this->_config['view'], compact('feastival'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\feastival  $feastival
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'desc' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $data = request()->all();
        $old_data = $this->feastivalRepository->findById($id);

        if (request()->hasFile('image'))
        {
            $imageName = $data['image'];
            if (isset($old_data['image']) && !empty($old_data['image'])) {
                $file_path = public_path('uploadImages/feastival').'/'.$old_data['image'];
                if(File::exists($file_path)) 
                {
                    unlink($file_path);
                }
            }
            
            $imageName1 = time().'.'.$imageName->extension();
            $imageName->move(public_path('uploadImages/feastival'), $imageName1);
            $data['image'] = $imageName1;
        }

        $this->feastivalRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'feastival']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feastival  $feastival
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->feastivalRepository->deleteData($id);
        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'feastival']));
        // return redirect()->route($this->_config['redirect']);
    }

    public function massDestroy()
    {
        $ids = explode(',', request()->input('indexes'));

        if ($ids != null) 
        {
            $this->feastivalRepository->massDataDelete($ids);
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
            $this->feastivalRepository->massDataUpdate($ids, $updateOption);
            session()->flash('success', trans('offer::app.offer.mass-update-success'));
        }
        return redirect()->back();
    }
}
