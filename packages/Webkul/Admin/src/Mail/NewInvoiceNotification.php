<?php

namespace Webkul\Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewInvoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The invoice instance.
     *
     * @param  \Webkul\Customer\Contracts\Invoice  $invoice
     */
    public $invoice;

    public $file;

    /**
     * Create a new message instance.
     *
     * @param  \Webkul\Customer\Contracts\Invoice  $invoice
     * @return void
     */
    public function __construct($invoice,$file = '')
    {
        $this->invoice = $invoice;

        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->invoice->order;

        if (isset($this->file) && !empty($this->file) ) {

            return $this->from(core()->getSenderEmailDetails()['email'], core()->getSenderEmailDetails()['name'])
                    ->to($order->customer_email, $order->customer_full_name)
                    ->subject(trans('shop::app.mail.invoice.subject', ['order_id' => $order->increment_id]))
                    ->view('shop::emails.sales.new-invoice')
                    ->attach($this->file);

        }else{
            return $this->from(core()->getSenderEmailDetails()['email'], core()->getSenderEmailDetails()['name'])
                    ->to($order->customer_email, $order->customer_full_name)
                    ->subject(trans('shop::app.mail.invoice.subject', ['order_id' => $order->increment_id]))
                    ->view('shop::emails.sales.new-invoice');
        }

        
    }
}
