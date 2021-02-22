<?php

namespace ACME\Zepo\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ACME\Zepo\Repositories\SupportTicketRepository;
use File;

class SupportTicketController extends Controller
{
    private $supportTicketRepository;
    public function __construct(SupportTicketRepository $supportTicketRepository)
    {
        $this->_config = request('_config');
        $this->supportTicketRepository = $supportTicketRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // $this->validate(request(), [
        //     'name'    => 'required',
        //     'email'    => 'required|email',
        //     'attachment'    => 'mimes:jpeg,jpg,png,gif|max:10000',
        // ]);
        
        $data = request()->all();
            
        $imageName = $request->attachment;
        if($imageName != null)
        {
            $imageName1 = time().'.'.$imageName->extension();
            $imageName->move(public_path('uploadImages/supportTicket'), $imageName1);
            $data['attachment'] = $imageName1;
        }

        $this->supportTicketRepository->create($data);

        Session()->flash('success', trans('shop::app.support-ticket.success-message'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SupportTicket  $supportTicket
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SupportTicket  $supportTicket
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SupportTicket  $supportTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SupportTicket  $supportTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
