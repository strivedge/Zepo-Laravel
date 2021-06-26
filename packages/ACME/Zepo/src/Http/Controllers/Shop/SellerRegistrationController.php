<?php

namespace ACME\Zepo\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use ACME\Zepo\Mail\SellerRegisterEmail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\User\Repositories\AdminRepository;

class SellerRegistrationController extends Controller
{
    use ValidatesRequests;
    protected $_config;
    protected $adminRepository;
    
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->_config = request('_config');
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

    public function create()
    {
        return view($this->_config['view']);
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'string|required',
            'email' => 'email|required|unique:admins,email',
            'password' => 'confirmed|min:6|required',
        ]);

        $data = request()->input();
        if (isset($data['password']) && $data['password']) {
            $data['password'] = bcrypt($data['password']);
            $data['api_token'] = Str::random(80);
        }
        // echo "After<pre>"; print_r($data); exit();

        Event::dispatch('user.admin.create.before');

        $admin = $this->adminRepository->create($data);

        if($admin->id != "") {
            $toAdmin = ['id' => $admin->id,
                        'name' => $admin->name,
                        'email' => $admin->email
                    ];

            try {
                    Mail::queue(new SellerRegisterEmail($toAdmin));

                    session()->flash('success', trans('admin::app.response.email-success', ['name' => 'Seller Verification']));
            } catch (\Exception $e) {
                report($e);
                session()->flash('error', trans('admin::app.response.email-error'));
            }
        }

        Event::dispatch('user.admin.create.after', $admin);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Registered wait for Verification']));

        return redirect()->route($this->_config['redirect']);
    }
}