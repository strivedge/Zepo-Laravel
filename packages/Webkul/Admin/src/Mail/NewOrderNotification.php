<?php

namespace Webkul\Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var  \Webkul\Sales\Contracts\Order  $order
     */
    public $order;
    public $file;

    /**
     * Create a new message instance.
     *
     * @param  \Webkul\Sales\Contracts\Order  $order
     * @return void
     */
    public function __construct($order,$file = '')
    {
        $this->order = $order;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (isset($this->file) && !empty($this->file) ) {

            return $this->from(core()->getSenderEmailDetails()['email'], core()->getSenderEmailDetails()['name'])
                    ->to($this->order->customer_email, $this->order->customer_full_name)
                    ->subject(trans('shop::app.mail.order.subject'))
                    ->view('shop::emails.sales.new-order')
                    ->attach($this->file);
            
        }else{
            
            return $this->from(core()->getSenderEmailDetails()['email'], core()->getSenderEmailDetails()['name'])
                    ->to($this->order->customer_email, $this->order->customer_full_name)
                    ->subject(trans('shop::app.mail.order.subject'))
                    ->view('shop::emails.sales.new-order');
        }

        
    }
}
