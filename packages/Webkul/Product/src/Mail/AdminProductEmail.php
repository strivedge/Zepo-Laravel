<?php

namespace Webkul\Product\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminProductEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    public $data;

    /**
     * Create a new mailable instance.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(auth()->guard('admin')->user()->email, auth()->guard('admin')->user()->name)
            ->to(core()->getAdminEmailDetails()['email'], core()->getAdminEmailDetails()['name'])
            ->subject(trans('admin::app.response.email-subject'))
            ->view('shop::emails.admin.seller-product-status')->with('data', $this->data);
    }
}