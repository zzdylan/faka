<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Events\OrderShipped;
use App\Models\Goods;
use Carbon\Carbon;

class ReceivePushController extends BaseController
{

    public function index(Request $request)
    {
        //处理付款成功推送
        \Log::info('支付成功回调',$request->all());
        $params = $request->all();
        $sign = $params['sign'];
        unset($params['sign']);
        //验证签名
        if ($sign != md5(md5(implode('',$params)) . config('personal_pay.secret'))) {
            return $this->error("签名不正确");
        }
        $order = Order::where('trade_no',$params['out_trade_no'])->first();
        if(!$order){
            return $this->error('订单不存在');
        }
        if ($order &&  $order->status == 0) {
            $payTime = Carbon::parse($params['pay_time']);
            $payType = $params['type'];
            $order->status = 1;
            $order->real_total_price = $params['real_price'];
            $order->pay_time = $payTime;
            switch ($payType){
                case 'wechat'://微信支付
                    $order->pay_type = 1;
                    break;
                case 'alipay'://支付宝支付
                    $order->pay_type = 2;
                    break;
            }
            $order->save();
            if($order->type == 2) {//自动发卡类型订单
                \DB::transaction(function () use ($order) {
                    if ($order->consumeCards() < $order->count) {
                        \Log::info('卡密库存不足');
                        return $this->error('卡密库存不足');
                    }
                    event(new OrderShipped($order));
                    $order->status = 3;
                    $order->save();
                });
            }
            //商品增加销量
            Goods::whereId($order->goods_id)
                ->increment('sold_count', $order->count);
            return $this->paySuccess();
        }
    }

    public function paySuccess(){
        return 'success';
    }

}
