<?php

namespace Custom\Testinominal\Http\Controllers;

use Illuminate\Http\Request;
use Custom\Testinominal\Repositories\TestinominalRepository;
use Custom\Testinominal\Models\Testinominal;
use DB;

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
        $posts = DB::table('master_testinominal')
        ->orderby('id','desc')
        ->get();
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
            $request->image = $imageName1;
            //echo "<pre>"; print_r($imageName1);exit();
        }
        
        //echo "<pre>"; print_r($request->all());exit();

        DB::table('master_testinominal')
    	->insert([
    		'title' => $request->title,
    		'image' => $request->image,
    		'desc' => $request->desc,
 			'date' => $request->date
        ]);

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
        $posts = DB::table('master_testinominal')->where('id', $id)->get();
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
        if($request->image != '')
        {
            if ($files = $request->image) 
            {
                $destinationPath = public_path('uploadImages'); // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
                
                DB::table('master_testinominal')->where('id', $id)->update([
                    'title' => $request->title,
    		        'image' => $profileImage,
    		        'desc' => $request->desc,
 			        'date' => $request->date
                ]);
            }
        }
        else
        {
            DB::table('master_testinominal')->where('id', $id)->update([
                'title' => $request->title,
    		    'desc' => $request->desc,
                'date' => $request->date
            ]);
        }
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
        DB::table('master_testinominal')->where('id', $id)->delete();
        return redirect()->route($this->_config['redirect']);
    }
}