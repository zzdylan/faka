<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $subject = '商品已发货';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        if($this->order->emailTemplate){
//            $blade = $this->order->emailTemplate->content_blade;
//            return blade2str(htmlspecialchars_decode($blade->content_blade),['order'=>$this->order]);
//        }else{
//            return '';
//        }
        return $this->view('mail.user.orderNotification');
    }
}
