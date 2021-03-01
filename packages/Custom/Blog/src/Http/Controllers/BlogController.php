<?php

namespace Custom\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Custom\Blog\Models\Blog;
// use Illuminate\Support\Facades\Validator;
use Custom\Blog\Repositories\BlogRepository;
use Illuminate\Foundation\Validation\ValidatesRequests;
use File;
use Validator;

class BlogController extends Controller
{
    use ValidatesRequests;
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

        $validator = Validator::make($request->all(), [
            'title'    => 'required|max:3',
            'image'    => 'required|mimes:jpeg,jpg,png,bmp,png,gif',
            'slug'     => 'required|unique:master_posts,slug',
            'content'  => 'required',
            'date'     => 'required',
        ]);

        if ($validator->fails()) 
        { 
            // return $validator->errors();
            // Session()->flash('error', "Fail");
            // return redirect()->back()->withErrors($validator);
            $errors = $validator->errors();
            // echo "<pre>"; print_r($errors); exit();
            return back()->withErrors($errors);
        }

            
        $imageName = $request->image;
        if($imageName != null)
        {
            $imageName1 = time().'.'.$imageName->extension();
            $imageName->move(public_path('uploadImages/blogs'), $imageName1);
            $data['image'] = 'uploadImages/blogs/'.$imageName1;
        }
        
        $this->blogRepository->create($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Blog']));

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
        $old_data = $this->blogRepository->findById($id);
        
        // $this->validate(request(), [
        //     'title' => 'required',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        //     'slug' => 'nullable|slug|unique:master_posts',
        //     'content' => 'required',
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
            $imageName->move(public_path('uploadImages/blogs'), $imageName1);
            $data['image'] = 'uploadImages/blogs/'.$imageName1;
        }

        $this->blogRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Blog']));

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
        $this->blogRepository->deleteData($id);

        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Blog']));

        // return redirect()->route($this->_config['redirect']);
    }

    public function massDestroy()
    {
        $ids = explode(',', request()->input('indexes'));

        if ($ids != null) 
        {
            $this->blogRepository->massDataDelete($ids);
            session()->flash('success', trans('blog::app.blogs.mass-destroy-success'));
        }
        return redirect()->back();
    }
}