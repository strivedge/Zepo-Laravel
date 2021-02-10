<?php

namespace Custom\Testinominal\Http\Controllers;

use Illuminate\Http\Request;
use Custom\Testinominal\Repositories\TestinominalRepository;
use File;

class TestinominalController extends Controller
{
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
        $posts = $this->testinominalRepository->getAll();
        return view($this->_config['view'], compact('posts'));
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
        $this->validate($request, [
            'title' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'date' => 'required',
        ]);

        $imageName = $request->image;
        if($imageName != null)
        {
            $imageName1 = time().'.'.$imageName->extension();  
            $imageName->move(public_path('uploadImages'), $imageName1);
            $data['image'] = $imageName1;
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
        $posts = $this->testinominalRepository->findById($id);
        return view($this->_config['view'], compact('posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'date' => 'required',
        ]);

        $data = request()->all();
        $old_data = $this->testinominalRepository->findById($id);
        
        if (request()->hasFile('image'))
        {
            $imageName = $data['image'];
            if (isset($old_data['image']) && !empty($old_data['image'])) {
                $file_path = public_path('uploadImages').'/'.$old_data['image'];
                if(File::exists($file_path)) 
                {
                    unlink($file_path);
                }
            }
            
            $imageName1 = time().'.'.$imageName->extension();
            $imageName->move(public_path('uploadImages'), $imageName1);
            $data['image'] = $imageName1;
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