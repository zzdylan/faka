<?php

namespace App\Listeners;

use App\Events\OrderShipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendShipmentNotification implements ShouldQueue
{
    /**
     * 创建事件监听器。
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 处理事件
     *
     * @param  OrderShipped  $event
     * @return void
     */
    public function handle(OrderShipped $event)
    {
        // 使用 $event->order 来访问 order ...
        if($event->order->type == 2){
            Mail::to($event->order->email)
                ->send(new \App\Mail\OrderShipped($event->order));
        }
    }
}