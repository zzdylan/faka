<?php

namespace App\Services;

use App\Models\Order;
use GuzzleHttp\Client;

class PersonalPay
{

    protected $baseUrl = 'http://118.89.190.171:3030/api/';

    public function create(Order $order){
        $payType = '';
        switch ($order->pay_type){
            case 1:
                $payType = 'wechat';
                break;
            case 2:
                $payType = 'alipay';
                break;
        }
        $params = [
            'price' => $order->total_price,
            'out_trade_no' => $order->trade_no,
            'type' => $payType,
            'notify_url' => config('personal_pay.notify_url'),
            'extend' => '',
        ];
        $params = array_filter($params);
        $params['sign'] = md5(md5(implode('', $params)) . config('personal_pay.secret'));
        $params['format'] = 'json';
        $client = new Client([
            'base_uri' => $this->baseUrl
        ]);
        $response = $client->request('POST', 'orders', [
            'form_params' => $params
        ]);
        $res = json_decode($response->getBody(),true);
        \Log::info('创建订单',$res);
        if($res['code'] == 0){
            throw new \Exception($res['msg']);
        }
        return $res['data'];
    }
}