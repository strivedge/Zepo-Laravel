<?php

namespace ACME\Zepo\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use ACME\Zepo\Mail\ContactEmail;
use ACME\Zepo\Mail\BulkBuyEmail;

class HomeController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }
    
    public function aboutUs()
    {
        return view($this->_config['view']);
    }

    public function storeDirectory()
    {
        return view($this->_config['view']);
    }

    public function covidProducts()
    {
        return view($this->_config['view']);
    }

    public function contactUs()
    {
        return view($this->_config['view']);
    }

    public function postContactUs()
    {
        $this->validate(request(), [
            'name'            => 'string|required',
            'email'           => 'required|email',
        ]);

        $data = collect(request()->all())->except('_token')->toArray();

        //echo"Contact data<pre>"; print_r($data);exit();

            $conatctData = ['email' => $data['email'],
                            'name' => $data['name'],
                            'phone' => $data['phone'],
                            'message' => $data['message']
                        ];

            try {
                Mail::queue(new ContactEmail($conatctData));
                session()->flash('success', trans('shop::app.contact.success'));
            } catch (\Exception $e) {
                report($e);
                session()->flash('error', trans('shop::app.contact.error'));
            }
        return redirect()->back();
    }

    public function getBulkRequest()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $quantity = $_POST['quantity'];
        $product_name = $_POST['product_name'];
        $additional = $_POST['additional'];

        $bulkData = [
            'name' => $name,
            'email' => $email,
            'contact' => $contact,
            'quantity' => $quantity,
            'product_name' => $product_name,
            'additional' => $additional
        ];

        try {
            Mail::queue(new BulkBuyEmail($bulkData));
            session()->flash('success', trans('shop::app.contact.success'));
        } catch (\Exception $e) {
            report($e);
            session()->flash('error', trans('shop::app.contact.error'));
        }

        return response()->json([
            'status' => true,
            'message' => "Success!",
            'data'    => $bulkData,
        ]);
    }

}
