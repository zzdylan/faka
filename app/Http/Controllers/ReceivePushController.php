<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Events\OrderShipped;

class ReceivePushController extends BaseController
{

    public function index(Request $request)
    {
        //处理付款成功推送
        if ($request->type == 'trade_TradePaid'
            && $request->status == 'TRADE_PAID') {
            $msg = json_decode(urldecode($request->msg),true);
            \Log::info('订单推送',$msg);
            $qrId = $msg['qr_info']['qr_id'];
            $order = Order::Where('out_trade_no',$qrId)->first();
            if ($order &&  $order->status == 0) {
                $payTime = $msg['full_order_info']['order_info']['pay_time'];
                $payType = $msg['full_order_info']['order_info']['pay_type'];
                $order->status = 1;
                $order->pay_time = $payTime;
                switch ($payType){
                    case 10://微信支付
                        $order->pay_type = 1;
                        break;
                        //支付宝支付状态todo
                }

                $order->save();
                if($order->type == 2) {//自动发卡类型订单
                    \DB::transaction(function () use ($order) {
                        if ($order->consumeCards() < $order->count) {
                            \Log::info('卡密库存不足');
                            return ['code'=>0,'msg'=>'success'];
                        }
                        event(new OrderShipped($order));
                        $order->status = 3;
                        $order->save();
                    });
                }
            }
        }
        return ['code'=>0,'msg'=>'success'];
    }

}
