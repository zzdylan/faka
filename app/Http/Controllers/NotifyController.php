<?php

namespace App\Http\Controllers;

use App\Events\OrderShipped;
use App\Models\Goods;
use App\Models\Order;
use Illuminate\Http\Request;
use Xhat\Payjs\Facades\Payjs;

class NotifyController extends BaseController
{
    public function payjs(Request $request)
    {
        // 接收异步通知,无需关注验签动作,已自动处理
        $data = Payjs::notify();
        \Log::info($data);
        //try {
            if ($data['return_code'] == 1) {
                $order = Order::where('trade_no', $data['out_trade_no'])->first();
                if (!$order) {
                    abort(400, '订单不存在');
                }
                if ($order && $order->status == Order::NO_PAY) {
                    $payTime = date('Y-m-d H:i:s', strtotime($data['time_end']));
                    $order->status = Order::PAYED;
                    $order->real_total_price = bcdiv($data['total_fee'], 100);
                    $order->pay_time = $payTime;
                    $order->pay_type = Order::WECHAT;
                    $order->save();
                    \DB::transaction(function () use ($order) {
                        if ($order->type == 2 && $order->consumeCards() < $order->count) { //自动发卡类型订单
                            abort(400, '卡密库存不足');
                        }
                        if($order->type == 2){
                            event(new OrderShipped($order));
                            $order->status = Order::SUCCESS;
                        }else if($order->type == 1){
                            $order->status = Order::PAYED;
                        }
                        $order->save();
                    });
                    //商品增加销量
                    Goods::whereId($order->goods_id)
                        ->increment('sold_count', $order->count);

                    return $this->paySuccess();
                }
            }
        //} catch (\Exception $e) {
        //    \Log::info($e->getMessage());
            return $this->paySuccess();
        //}

    }

    public function paySuccess()
    {
        return 'success';
    }
}
