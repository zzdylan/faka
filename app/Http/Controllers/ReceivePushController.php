<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Events\OrderShipped;
use App\Models\Goods;

class ReceivePushController extends BaseController
{

    public function index(Request $request)
    {
        //处理付款成功推送
        if ($request->type == 'trade_TradePaid'
            && $request->status == 'TRADE_PAID') {
            $msg = json_decode(urldecode($request->msg),true);
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
                    case 2://支付宝支付
                        $order->pay_type = 2;
                        break;
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
                //商品增加销量
                Goods::whereId($order->goods_id)
                    ->increment('sold_count', $order->count);
            }
        }
        return ['code'=>0,'msg'=>'success'];
    }

}
