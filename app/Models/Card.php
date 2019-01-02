<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function goods(){
        return $this->belongsTo(Goods::class,'goods_id');
    }

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }

}
