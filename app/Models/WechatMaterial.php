<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class WechatMaterial extends Model
{
    public function get()
    {
        $app = app('wechat.official_account');

        return $material;
    }

}