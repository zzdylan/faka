<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Goods;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\PersonalPay;
use Xhat\Payjs\Facades\Payjs;

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
            $order->type = $goods->type;
            $order->pay_type = $request->pay_type;
            $order->password = $request->password;
            $order->email = $request->email;
            $order->pay_account = $request->pay_account;
//            $order->goods->first_input;//第一个输入框
//            $order->goods->more_input;//更多输入框,逗号隔开
            $firstInput = (array)$order->goods->first_input;
            $moreInput = explode(',',$order->goods->more_input);
            $inputKeys = array_merge($firstInput,$moreInput);
            $inputValues = array_merge((array($order->pay_account)),(array)$request->more_input_value);
            $inputJsonArray = [];
            foreach($inputKeys as $key=>$inputKey){
                $inputJsonArray[$key]['name'] = $inputKeys[$key];
                $inputJsonArray[$key]['value'] = $inputValues[$key];
            }
            $order->more_input_value = json_encode($inputJsonArray,JSON_UNESCAPED_UNICODE);
            $order->ip = $request->ip();
            $order->save();
            if ($goods->type == 1 && $goods->decreaseStock($order->count) <= 0) {
                throw new InvalidRequestException('该商品库存不足');
            }
            return $order;
        });
        return $this->success('创建订单成功', ['order_id' => $order->id]);
    }

    public function pay($id)
    {
        $order = Order::find($id);
        if (!$order) {
            abort(404);
        }
        // 构造订单基础信息
        $data = [
            'body' => $order->name,
            'total_fee' => bcmul($order->total_price,100),
            'out_trade_no' => $order->trade_no,
            'attach' => '',                    // 订单附加信息(可选参数)
            'notify_url' => url('api/notify'),     // 异步通知地址(可选参数)
        ];
        if($order->pay_type == Order::ALIPAY){
            $data['type'] = 'alipay';
        }
        if(is_weixin()){
			$wechatInfo = session('payjs_wechat_info');
			$data['openid'] = $wechatInfo['openid'];
			$payjsData = Payjs::jsapi($data);
			if($payjsData['return_code'] != 1){
				return $this->error($payjsData['return_msg']);
			}
			return view('home.mobilePayment',['order'=>$order,'pay_data'=>$payjsData['jsapi']]);
        }
        try{
            $payjsData = Payjs::native($data);
            if($payjsData['return_code'] != 1){
                abort(400,$payjsData['return_msg']);
            }

            $detect = new \Mobile_Detect;
            if($detect->isMobile() && $order->pay_type == Order::ALIPAY){
                return view('home.mobilePayment',['order'=>$order,'code_url'=>$payjsData['code_url']]);
                //return view('home.mobilePayment',['order'=>$order,'code_url'=>url('orders/'.$id)]);
            }
			if($detect->isMobile()){
				$codeUrl = url('orders/'.$id);
			}else{
				$codeUrl = $payjsData['code_url'];
			}
            $imageBase64 = base64_encode(QrCode::format('png')->size(200)->generate($codeUrl));
        }catch (\Exception $e){
            return "<script>alert(\"{$e->getMessage()}\");location.href='/'</script>";
        }
        $payQrcode = 'data:image/png;base64,'.$imageBase64;
        return view('home.payment', compact('order', 'payQrcode'));
    }

    public function show(Order $order)
    {
        return $order;
    }

    public function data(Order $order, Request $request)
    {
        if ($order->type == 2) {
            if ($order->password != $request->password) {
                return ['code' => 1, 'message' => '密码错误'];
            }
            $cards = $order->cards->pluck('content')->toArray();
            $data = implode("\r\n", $cards);
            return ['code' => 0, 'data' => $data];
        }
        return ['code' => 0, 'data' => $order->pay_account];
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
