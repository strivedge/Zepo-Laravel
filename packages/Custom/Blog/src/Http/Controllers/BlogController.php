<?php

namespace Custom\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Custom\Blog\Repositories\BlogRepository;
use Custom\Blog\Models\Blog;
use DB;

class BlogController extends Controller
{
    private $blogRepository;
    public function __construct(BlogRepository $blogRepository)
    {
        $this->middleware('admin');
        $this->_config = request('_config');
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->blogRepository->getAll();
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
            'content' => 'required',
            'date' => 'required',
        ]);

        $imageName = $request->image;
        if($imageName != null)
        {
            $imageName1 = time().'.'.$imageName->extension();
            $imageName->move(public_path('uploadImages'), $imageName1);
            $data['image'] = $imageName1;
        }
        
        $this->blogRepository->create($data);

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
        $posts = $this->blogRepository->findById($id);
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
        $data = request()->all();
        $this->validate($request, [
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'content' => 'required',
            'date' => 'required',
        ]);

        if($request->image != '')
        {
            if ($files = $request->image) 
            {
                $destinationPath = public_path('uploadImages'); // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
                $data['image'] = $profileImage;
            }
        }

        $this->blogRepository->update($data, $id);
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
        // if($id != null)
        // {
        //     $result['status'] = true;
        //     echo json_encode($result);
        $this->blogRepository->deleteData($id);
        // }
        // else
        // {
        //     $result['status'] = false;
        // }
        // return redirect()->route($this->_config['redirect']);
    }
}