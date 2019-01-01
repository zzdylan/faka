<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function goods(){
        return $this->belongsTo(Goods::class,'goods_id');
    }
}
