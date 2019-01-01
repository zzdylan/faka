<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class WechatUser extends Model
{
    public function get()
    {
        $app = app('wechat.official_account');
        $wechatUsers = $app->user->list();
        $openids =$wechatUsers['data']['openid'];
        $usersInfo = $app->user->select($openids);
        $users = static::hydrate($usersInfo['user_info_list']);
        return $users;
    }

}