<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function cards(){
        return $this->hasMany(Card::class,'goods_id');
    }

    public function emailTemplate(){
        return $this->belongsTo(EmailTemplate::class,'email_template_id');
    }

    public function goodsStock(){
        switch ($this->type){
            case 1:
                return $this->stock;
            case 2:
                return $this->cards()->where('status',0)->count();
        }
    }

    public function decreaseStock($amount)
    {
        if ($amount < 0) {
            throw new InternalException('减库存不可小于0');
        }

        return $this->newQuery()->where('id', $this->id)->where('stock', '>=', $amount)->decrement('stock', $amount);
    }

    public function addStock($amount)
    {
        if ($amount < 0) {
            throw new InternalException('加库存不可小于0');
        }
        $this->increment('stock', $amount);
    }

    public function addSold($amount){
        $this->increment('sold_count', $amount);
    }

}
