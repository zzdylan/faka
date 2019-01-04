<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
        'more_input_value' => 'array',
    ];
    protected $hidden = ['password'];

    public function cards(){
        return $this->hasMany(Card::class,'order_id');
    }

    public function consumeCards(){
        return (new Card())->newQuery()
            ->where('status', 0)
            ->where('goods_id',$this->goods_id)
            ->limit($this->count)
            ->update(['status'=>1,'order_id'=>$this->id]);
    }

}
