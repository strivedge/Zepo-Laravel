<?php 
namespace ACME\RazorPay\Http\Controllers;

use Illuminate\Routing\Controller;
use Webkul\Checkout\Facades\Cart;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Razorpay\Api\Api;
use Session;
use Redirect;
use ACME\RazorPay\Repositories\RazorpayRepository;
use Webkul\Sales\Repositories\OrderRepository;

class RazorpayController extends Controller
{   
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    private $razorpayRepository;

    protected $orderRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(RazorpayRepository $razorpayRepository,OrderRepository $orderRepository)
    {
        $this->_config = request('_config');
        $this->razorpayRepository = $razorpayRepository;
        $this->orderRepository = $orderRepository;
    }

    public function payWithRazorpay()
    {        
        return view($this->_config['view']);
    }

    public function payment(Request $request)
    {
        //Input items of form
        //$input = request()->all();
         $input = $request->all();
        //get API Configuration 
        //echo"<pre>input"; print_r($input);exit();
        $api = new Api(config('custom.razor_key'), config('custom.razor_secret'));
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        /*$order = $api->order->create(array(
          'receipt' => '123',
          'amount' => $input['totalAmount'],
          'currency' => 'INR'
          )
        );

        $payments = $api->order->fetch($order->id)->payments();
        */

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 

               // echo"<pre>"; print_r($response);exit();

                if ($response->status == 'captured' && empty($response->error_code)) {

                    $order = $this->orderRepository->create(Cart::prepareDataForOrder());

                    $tranData = array(
                          'customer_id' => $input['customer_id'],
                          'is_guest' => $input['is_guest'],
                          'customer_first_name' => $input['customer_first_name'],
                          'customer_last_name' => $input['customer_last_name'],
                          'order_id' => $order->id, 
                          'payment_id' => $input['razorpay_payment_id'], 
                          'transaction_payment_id' => $response->id, 
                          'sub_total' => $input['sub_total'],
                          'grand_total' => $input['totalAmount'],
                          'amount' => $response->amount, 
                          'currency' => $response->currency,
                          'cart_id' => $input['cart_id'],
                          'amount_captured' => $response->captured, 
                          'payment_method' => 'razorpay',
                          'pay_method' => $response->method,
                          'customer_contact' => $response->contact, 
                          'customer_email' =>$response->email, 
                          'date' => date('Y-m-d', strtotime($response->created_at)),
                          'payment_status' => $response->status,
                        );

                    $trans = $this->razorpayRepository->create($tranData);

                    //echo"trans"; print_r( $trans );
                    //echo"order"; print_r( $order );exit();

                    Cart::deActivateCart();

                    session()->flash('order', $order);


                    return response()->json([
                        'success'      => true,
                        'msg'      => 'Payment Done',
                        'response' => $response,
                    ]);
                }else{
                    return response()->json([
                        'success'      => false,
                        'msg'      => 'Payment Failed',
                        'response' => $response,
                    ]);
                }

                

            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                //return redirect()->back();

                    $tranData = array(
                          'customer_id' => $input['customer_id'],
                          'is_guest' => $input['is_guest'],
                          'customer_first_name' => $input['customer_first_name'],
                          'customer_last_name' => $input['customer_last_name'], 
                          'sub_total' => $input['sub_total'],
                          'grand_total' => $input['totalAmount'],
                          'cart_id' => $input['cart_id'], 
                          'payment_method' => 'razorpay',
                          'date' => date('Y-m-d', strtotime($response->created_at)),
                          'payment_status' => 'failed',
                          'payment_error' => $e->getMessage(),
                        );

                    $this->razorpayRepository->create($tranData);

                return response()->json([
                        'success'      => false,
                        'msg'      => $e->getMessage()
                    ]);
            }

            // Do something here for store payment details in database...
        }
        
        \Session::put('success', 'Payment successful, your order will be despatched in the next 48 hours.');

        return response()->json([
            'success'      => false,
            'msg'      => 'Invalid Input'
        ]);
    }
}