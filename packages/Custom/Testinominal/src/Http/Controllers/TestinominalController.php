<?php

namespace Custom\Testinominal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Custom\Testinominal\Models\Testinominal;
use Custom\Testinominal\Repositories\TestinominalRepository;
use Illuminate\Foundation\Validation\ValidatesRequests;
use File;
use Validator;

class TestinominalController extends Controller
{
    use ValidatesRequests;
    private $testinominalRepository;
    public function __construct(TestinominalRepository $testinominalRepository)
    {
        $this->middleware('admin');
        $this->_config = request('_config');
        $this->testinominalRepository = $testinominalRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testinominal = $this->testinominalRepository->getAll();
        return view($this->_config['view'], compact('testinominal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->all();

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,bmp,png,gif',
            'desc'  => 'required',
            'date' => 'required',
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
            $imageName->move(public_path('uploadImages/testinominal'), $imageName1);
            $data['image'] = 'uploadImages/testinominal/'.$imageName1;
        }
        $this->testinominalRepository->create($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Testinominal']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $testinominal = $this->testinominalRepository->findById($id);
        return view($this->_config['view'], compact('testinominal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = request()->all();
        $old_data = $this->testinominalRepository->findById($id);
        
        // $this->validate($request, [
        //     'title' => 'required',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        //     'date' => 'required',
        // ]);

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
            $imageName->move(public_path('uploadImages/testinominal'), $imageName1);
            $data['image'] = 'uploadImages/testinominal/'.$imageName1;
        }

        $this->testinominalRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Testinominal']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->testinominalRepository->deleteData($id);

        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Testinominal']));
        // return redirect()->route($this->_config['redirect']);
    }

    public function massDestroy()
    {
        $ids = explode(',', request()->input('indexes'));

        if ($ids != null) 
        {
            $this->testinominalRepository->massDataDelete($ids);
            session()->flash('success', trans('testinominal::app.testinominal.mass-destroy-success'));

        }
        return redirect()->back();
    }
}