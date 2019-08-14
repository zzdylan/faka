<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends BaseController
{

    public function index()
    {
        return view('home.index');
    }

    public function pay(){
        $params = [
            'price' => 100,
            'out_order_id' => buildTradeNo(),
            'type' => 'wechat',
            'product_id' => '',
            'notifyurl' => '',
            'returnurl' => 'http://www.baidu.com',
            'extend' => '',
        ];
        $params = array_filter($params);
        $params['sign'] = md5(md5(implode('', $params)) . '123456');
        $params['format'] = 'json';
        $client = new Client([
            'base_uri' => 'https://fastadmin.51godream.com/addons/pay/api/'
        ]);
        $response = $client->request('GET', 'create', [
            'query' => $params
        ]);
        return $response->getBody();
    }

}
