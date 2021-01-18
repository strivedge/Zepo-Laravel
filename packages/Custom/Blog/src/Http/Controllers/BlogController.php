<?php

namespace Custom\Blog\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data['posts'] = DB::table('posts')->get();
        $posts = DB::table('master_posts')
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
        // echo "<pre>";
        // print_r($request->all());exit();
        $this->validate($request, [
            'blog_title' => 'required',
            'blog_image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'blog_content' => 'required',
            'blog_date' => 'required',
        ]);

        $imageName = $request->blog_image;
        if($imageName!= null)
        {
            $imageName1 = time().'.'.$imageName->extension();  
            $imageName->move(public_path('uploadImages'), $imageName1);
        }
        $request->blog_image = $imageName1;

        DB::table('master_posts')
    	->insert([
    		'title' => $request->blog_title,
    		'image' => $request->blog_image,
    		'content' => $request->blog_content,
 			'date' => $request->blog_date
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
        $posts = DB::table('master_posts')->where('id', $id)->get();
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
        // print_r($request->id);exit();
        $this->validate($request, [
            'blog_title' => 'required',
            'blog_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'blog_content' => 'required',
            'blog_date' => 'required',
        ]);
        if($request->blog_image != '')
        {
            if ($files = $request->blog_image) 
            {
                $destinationPath = public_path('uploadImages'); // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
                
                DB::table('master_posts')->where('id', $id)->update([
                    'title' => $request->blog_title,
    		        'image' => $profileImage,
    		        'content' => $request->blog_content,
 			        'date' => $request->blog_date
                ]);
            }
        }
        else
        {
            DB::table('master_posts')->where('id', $id)->update([
                'title' => $request->blog_title,
    		    'content' => $request->blog_content,
                'date' => $request->blog_date
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
        DB::table('master_posts')->where('id', $id)->delete();
        return redirect()->route($this->_config['redirect']);
    }
}