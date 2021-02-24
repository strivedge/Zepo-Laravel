<?php

namespace ACME\Zepo\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Validator;
use ACME\Zepo\Mail\SupportTicketEmail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use ACME\Zepo\Repositories\SupportTicketRepository;
// use Validator;
use File;

class SupportTicketController extends Controller
{
    use ValidatesRequests;
    protected $_config;
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
        return view($this->_config['view']);
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

        $this->validate(request(), [
            'name'    => 'required',
            'email'    => 'required',
            'attachment'    => 'nullable|mimes:jpeg,jpg,bmp,png',
        ]);
        // echo "<pre>"; print_r($val); exit();
            
        $imageName = $request->attachment;
        if($imageName != null)
        {
            $imageName1 = time().'.'.$imageName->extension();
            $imageName->move(public_path('uploadImages/supportTicket'), $imageName1);
            $data['attachment'] = $imageName1;
        }

        // for getting all data
        $check = $this->supportTicketRepository->create($data);

        // Send email to admin for support ticket
        if($check->id != "")
        {
            $toAdmin = ['id' => $check->id,
                        'name' => $check->name,
                        'email' => $check->email,
                        'message' => $check->message
                    ];

            try {
                    Mail::queue(new SupportTicketEmail($toAdmin));

                    session()->flash('success', trans('admin::app.response.email-success', ['name' => 'Support']));
            } catch (\Exception $e) {
                report($e);
                session()->flash('error', trans('admin::app.response.email-error'));
            }
        }

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
    public function edit($id)
    {
        $supportTicket = $this->supportTicketRepository->findById($id);
        return view($this->_config['view'], compact('supportTicket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SupportTicket  $supportTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = request()->all();

        $this->validate(request(), [
            'name'    => 'required',
            'email'    => 'required',
            'attachment'    => 'nullable|mimes:jpeg,jpg,bmp,png',
        ]);
        
        $old_data = $this->supportTicketRepository->findById($id);

        if (request()->hasFile('attachment'))
        {
            $imageName = $data['attachment'];
            if (isset($old_data['attachment']) && !empty($old_data['attachment'])) {
                $file_path = public_path('uploadImages/supportTicket').'/'.$old_data['attachment'];
                if(File::exists($file_path)) 
                {
                    unlink($file_path);
                }
            }
            
            $imageName1 = time().'.'.$imageName->extension();
            $imageName->move(public_path('uploadImages/supportTicket'), $imageName1);
            $data['attachment'] = $imageName1;
        }

        $this->supportTicketRepository->update($data, $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Support Ticket']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SupportTicket  $supportTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->supportTicketRepository->deleteData($id);
        session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Support Ticket']));
        // return redirect()->route($this->_config['redirect']);
    }

    public function massDestroy()
    {
        $ids = explode(',', request()->input('indexes'));

        if ($ids != null) 
        {
            $this->supportTicketRepository->massDataDelete($ids);
            session()->flash('success', trans('zepo::app.support-ticket.mass-destroy-success'));
        }
        return redirect()->back();
    }
}
