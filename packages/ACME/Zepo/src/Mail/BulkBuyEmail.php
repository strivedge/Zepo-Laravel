<?php

namespace ACME\Zepo\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BulkBuyEmail extends Mailable
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
       return $this->from(core()->getSenderEmailDetails()['email'], core()->getSenderEmailDetails()['name'])
            ->to(core()->getAdminEmailDetails()['email'], core()->getAdminEmailDetails()['name'])
            ->subject(trans('shop::app.products.bulk-buy-request'))
            ->view('shop::emails.customer.bulk-buy-request')->with('data', $this->data);
    }
}