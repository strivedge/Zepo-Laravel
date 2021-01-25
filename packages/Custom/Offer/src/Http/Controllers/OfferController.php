<?php

namespace Custom\Offer\Http\Controllers;

use Illuminate\Http\Request;
use Custom\Offer\Repositories\OfferRepository;
use Custom\Offer\Models\Offer;
use DB;

class OfferController extends Controller
{
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
            $imageName->move(public_path('uploadImages/offer'), $imageName1);
            $data['image'] = $imageName1;
        }

        $this->offerRepository->create($data);

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer, $id)
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
    public function update(Request $request, Offer $offer, $id)
    {
        $data = request()->all();
        $this->validate($request, [
            'title' => 'required',
            'desc' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if($request->image != '')
        {
            if ($files = $request->image) 
            {
                $destinationPath = public_path('uploadImages/offer'); // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
                $data['image'] = $profileImage;
            }
        }

        $this->offerRepository->update($data, $id);
        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer, $id)
    {
        $this->offerRepository->deleteData($id);
        // return redirect()->route($this->_config['redirect']);
    }
}
