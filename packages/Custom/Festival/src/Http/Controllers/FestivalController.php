<?php

namespace Custom\Festival\Http\Controllers;

use Illuminate\Http\Request;
use Custom\Festival\Repositories\FestivalRepository;
use Webkul\Product\Repositories\ProductRepository;
use File;
use Validator;

class FestivalController extends Controller
{
    protected $_config;
    private $festivalRepository;
     /**
     * ProductRepository object
     *
     * @var \Webkul\Product\Repositories\ProductRepository
     */
    protected $productRepository;

    public function __construct(FestivalRepository $festivalRepository,
        ProductRepository $productRepository)
    {
        $this->middleware('admin');
        $this->_config = request('_config');
        $this->festivalRepository = $festivalRepository;
         $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $festival = $this->festivalRepository->getAll();

        $festivalp = $this->productRepository->getFestivalProducts();

        //print_r($festivalp);exit();
        return view($this->_config['view'], compact('festival'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = $this->productRepository->with(['variants', 'variants.inventories'])->findOrFail(103);
        return view($this->_config['view'], compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo "<pre>"; print_r(request()->all());exit();
        $req = request()->all();

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,bmp,svg',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        if ($validator->fails()) 
        {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors);
        }

        $data = ['title' => $req['title'],
                'short_desc' => $req['short_desc'],
                'long_desc' => $req['long_desc'],
                'start_date' => $req['start_date'],
                'end_date' => $req['end_date'],
                'status' => $req['status'],
                ];

        if(!empty($req['up_sell'])) {
            $data['up_sell'] = $req['up_sell'];
        }
        else {
            $data['up_sell'] = [];
        }
        
        if (request()->hasFile('image'))
        {
            $imageName = $request->image;
            $imageName1 = time().'.'.$imageName->extension();  
            $imageName->move(public_path('uploadImages/festival'), $imageName1);
            $data['image'] = 'uploadImages/festival/'.$imageName1;
        }

        $storeData = $this->festivalRepository->create($data);

        $storeData = $this->festivalRepository->updateStatus($storeData['id']);

        //echo"<pre>";print_r($storeData['id']);exit();
        /*if (!empty($storeData) && !empty($req['up_sell'])) {
            foreach ($req['up_sell'] as $val) {

                $productData = ['parent_id'=> $storeData['id'],
                                'product_id' => $val
                ];

                $prodStoredata = $this->festivalRepository->createProduct($productData);
              
            }
            
        }*/

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Festival']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Festival  $festival
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Festival  $festival
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $festival = $this->festivalRepository->findById($id);
        
        $product = $this->productRepository->getFesivalProducts($id);

        //echo "<pre>"; print_r($product);exit();
        return view($this->_config['view'], compact('festival','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\festival  $festival
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $req = request()->all();
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,bmp',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
            
        if ($validator->fails()) 
        {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors);
        }

        $data = ['title' => $req['title'],
                'short_desc' => $req['short_desc'],
                'long_desc' => $req['long_desc'],
                'start_date' => $req['start_date'],
                'end_date' => $req['end_date'],
                'status' => $req['status'],
                ];

        if(!empty($req['up_sell'])) {
            $data['up_sell'] = $req['up_sell'];
        }
        else {
            $data['up_sell'] = [];
        }

        //echo"<pre>"; print_r($data);exit();

        $old_data = $this->festivalRepository->findById($id);

        if (request()->hasFile('image'))
        {
            $imageName = $request->image;
            if (isset($old_data['image']) && !empty($old_data['image'])) {
                $file_path = public_path().'/'.$old_data['image'];
                if(File::exists($file_path)) 
                {
                    unlink($file_path);
                }
            }
            
            $imageName1 = time().'.'.$imageName->extension();
            $imageName->move(public_path('uploadImages/festival'), $imageName1);
            $data['image'] = 'uploadImages/festival/'.$imageName1;
        }

        $storeData = $this->festivalRepository->update($data, $id);

        $storeData = $this->festivalRepository->updateStatus($id);

         //echo"<pre>";print_r($storeData['id']);exit();

        //$this->festivalRepository->deleteFesivalProduct($id);
       
        /*if (!empty($storeData) && !empty($req['up_sell'])) {
            foreach ($req['up_sell'] as $val) {

                $productData = ['parent_id'=> $storeData['id'],
                                'product_id' => $val
                ];

                $prodStoredata = $this->festivalRepository->createProduct($productData);

                //echo "<pre>";print_r($prodStoredata);exit();
              
            }
            
        }*/

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'festival']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Festival  $festival
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->festivalRepository->deleteData($id);
        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'festival']));
        // return redirect()->route($this->_config['redirect']);
    }

    public function massDestroy()
    {
        $ids = explode(',', request()->input('indexes'));

        if ($ids != null) 
        {
            $this->festivalRepository->massDataDelete($ids);
            session()->flash('success', trans('festival::app.festival.mass-destroy-success'));
        }
        return redirect()->back();
    }

    public function massUpdate()
    {
        $ids = explode(',', request()->input('indexes'));
        $updateOption = request()->input('update-options');

        if ($ids != null && $updateOption != null) 
        {
            $this->festivalRepository->massDataUpdate($ids, $updateOption);
            session()->flash('success', trans('festival::app.festival.mass-update-success'));
        }
        return redirect()->back();
    }
}
