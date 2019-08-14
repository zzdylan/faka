<?php

namespace App\Listeners;

use App\Events\OrderShipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendShipmentNotification
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
//        Mail::to($event->order->email)
//            ->send(new \App\Mail\OrderShipped($event->order));

        $order = $event->order;
        if(!$order->goods->emailTemplate){
            \Log::info('没有邮件模板');
            return;
        }
        $blade = $order->goods->emailTemplate->content_blade;
        $content = blade2str(htmlspecialchars_decode($blade),['order'=>$order]);
        try{
            Mail::raw($content, function ($message) use ($order) {
                $to = $order->email;
                $message ->to($to)->subject('邮件通知');
                $message->setContentType('text/html');
            });
        }catch(\Exception $e){
            \Log::info('发送邮件异常:'.$e->getMessage());
        }

    }
}