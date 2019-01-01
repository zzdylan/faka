<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WechatMenuController extends BaseController
{
    public function index(Request $request){
        $app = app('wechat.official_account');
        $list = $app->menu->list();
        if(isset($list['errcode'])){
            return $list;
        }
        return ['errcode'=>0,'data'=>$list];
    }

    public function store(Request $request){
        $buttons = $request->input('menu');
        $buttons = json_decode($buttons,true);
        $buttons = $buttons['button'];
        $app = app('wechat.official_account');
        $result = $app->menu->create($buttons);
        return $result;
    }

    public function destroy(){
        $app = app('wechat.official_account');
        $result = $app->menu->delete(); // 删除全部
        return $result;
    }

}
