<?php

namespace Webkul\SocialLogin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\SocialLogin\Repositories\CustomerSocialAccountRepository;

class LoginController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * CustomerSocialAccountRepository
     *
     * @var \Webkul\SocialLogin\Repositories\CustomerSocialAccountRepository
     */
    protected $customerSocialAccountRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\SocialLogin\Repositories\CustomerSocialAccountRepository  $customerSocialAccountRepository
     * @return void
     */
    public function __construct(CustomerSocialAccountRepository $customerSocialAccountRepository)
    {
        $this->customerSocialAccountRepository = $customerSocialAccountRepository;

        $this->_config = request('_config');
    }

    /**
     * Redirects to the social provider
     *
     * @param  string  $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {

        //echo"GOOGLE_CLIENT_ID:<pre>";print_r(env('GOGGLE_CLIENT_ID'));exit();
        try {
          //echo "payal<pre>";  print_r(Socialite::driver($provider)->redirect());exit();
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {

           //echo"<pre>";print_r($e);exit();
            session()->flash('error', $e->getMessage());

            //return redirect()->route('customer.session.index');
        }
    }

    /**
     * Handles callback
     *
     * @param  string  $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {

            $user = Socialite::driver($provider)->user();
            //echo"User:<pre>";print_r($user);
        } catch (\Exception $e) {
            //echo"Error:<pre>";print_r($e);exit();

             session()->flash('error', 'Try after some time');
            return redirect()->route('customer.session.index');
        }

        //echo"provider:<pre>";print_r( $provider);

        $customer = $this->customerSocialAccountRepository->findOrCreateCustomer($user, $provider);

        // echo"Customer:<pre>";print_r($customer);exit();

        auth()->guard('customer')->login($customer, true);

        // Event passed to prepare cart after login
        Event::dispatch('customer.after.login', $customer->email);

        return redirect()->intended(route($this->_config['redirect']));
    }
}