<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'goods_categories';

    public function goods(){
        return $this->hasMany(Goods::class,'category_id');
    }
}
