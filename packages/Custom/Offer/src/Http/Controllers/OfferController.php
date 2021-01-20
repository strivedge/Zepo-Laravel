<?php

namespace Custom\Offer\Http\Controllers;

use App\Offer;
use Illuminate\Http\Request;
use DB;
use Custom\Offer\Models\Testinominal;

class OfferController extends Controller
{
    protected $_config;

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
        $offers = DB::table('master_offers')
        ->orderby('id','desc')
        ->get();
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
            $request->image = $imageName1;
        }

        DB::table('master_offers')
    	->insert([
    		'title' => $request->title,
    		'desc' => $request->desc,
    		'image' => $request->image,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status
        ]);

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
        $offers = DB::table('master_offers')->where('id', $id)->get();
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

                DB::table('master_offers')->where('id', $id)->update([
                    'title' => $request->title,
    		        'desc' => $request->desc,
    		        'image' => $profileImage,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'status' => $request->status
                ]);
            }
        }
        else
        {
            DB::table('master_offers')->where('id', $id)->update([
                'title' => $request->title,
                'desc' => $request->desc,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status
            ]);
        }
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
        DB::table('master_offers')->where('id', $id)->delete();
        return redirect()->route($this->_config['redirect']);
    }
}
