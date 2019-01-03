<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Goods;
use Carbon\Carbon;
use App\Jobs\UpdateOrders;

class OrderController extends BaseController
{

    public function store(Request $request)
    {
        $goods = Goods::find($request->goods_id);
        if (!$goods) {
            return $this->error('该商品不存在或者已被删除');
        }
        if ($goods->status === 0) {
            return $this->error('该商品已下架');
        }
        if ($goods->goodsStock() === 0) {
            return $this->error('该商品库存不足');
        }
        $count = $request->count;
        if ($count > 0 && $count > $goods->goodsStock()) {
            return $this->error('该商品库存不足');
        }
        $order = \DB::transaction(function () use ($goods, $request) {
            $order = new Order();
            $order->trade_no = buildTradeNo();
            $order->name = $goods->name . 'x' . $request->count;
            $order->goods_id = $goods->id;
            $order->goods_name = $goods->name;
            $order->unit_price = $goods->price;
            $order->count = $request->count;
            $order->total_price = $goods->price * $request->count;
            $order->pay_account = '';
            $order->type = $goods->type;
            $order->pay_type = 1;
            $order->password = $request->password;
            $order->email = $request->email;
            $order->pay_account = $request->pay_account;
            $order->more_input_value = $request->more_input_value;
            $order->save();
            if ($goods->type == 1 && $goods->decreaseStock($order->count) <= 0) {
                throw new InvalidRequestException('该商品库存不足');
            }
            return $order;
        });
        return $this->success('创建订单成功', ['order_id' => $order->id]);
    }

    public function payQrcode(Order $order)
    {
        $result = app('youzan')->post('youzan.pay.qrcode.create', [
            'qr_type' => 'QR_TYPE_DYNAMIC',  // 确定金额二维码，只能被支付一次
            'qr_price' => $order->total_price * 100,  // 金额：分
            'qr_name' => $order->name, // 收款理由
            'qr_source' => $order->trade_no, // 自定义字段，你可以设置为网站订单号
        ]);
        $order->out_trade_no = $result['response']['qr_id'];
        $order->save();
        return $result['response'];
    }

    public function pay($id)
    {
        $order = Order::find($id);
        if (!$order) {
            abort(404);
        }
        $result = $this->payQrcode($order);
        UpdateOrders::dispatch($order)
            ->delay(Carbon::now()->addSeconds(2));
        return view('home.pay', compact('order', 'result'));
    }

    public function show(Order $order){
        return $order;
    }

    public function data(Order $order, Request $request)
    {
        if ($order->type == 2) {
            if($order->password != $request->password){
                return ['code'=>1,'message'=>'密码错误'];
            }
            $cards = $order->cards->pluck('content')->toArray();
            $data = implode("\r\n",$cards);
            return ['code'=>0,'data'=>$data];
        }
        return ['code'=>0,'data'=>$order->pay_account];
    }

    public function index(Request $request)
    {
        $type = (int)$request->input('type', '');
        $search = $request->search;
        $password = $request->password;
        switch ($type) {
            case 1:
                $orders = Order::where('type', $type)
                    ->where('pay_account', $search)
                    ->paginate($request->limit);
                break;
            case 2:
                $orders = Order::where('type', $type)
                    ->where('email', $search)
                    ->paginate($request->limit);
                break;
            default:
                $orders = Order::where('id', '<', 0)->paginate($request->limit);
        }
        return $orders;
    }

}
