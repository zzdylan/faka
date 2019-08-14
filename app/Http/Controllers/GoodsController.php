<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;

class GoodsController extends BaseController
{
    public function index(Request $request){
        $categoryId = $request->get('q');
        return Goods::select('id','name as text')
            ->where('category_id', $categoryId)
            ->orderBy('sort','asc')
            ->get();
    }

    public function getByCardType(Request $request){
        $categoryId = $request->get('q');
        return Goods::select('id','name as text')
            ->where('category_id', $categoryId)
            ->where('type',2)
            ->orderBy('sort','asc')
            ->get();
    }

    public function show(Goods $goods){
        $goods->goods_stock = $goods->goodsStock();
        $goods->more_input = str_replace('，',',',$goods->more_input);
        $goods->more_input = $goods->more_input ? explode(',',$goods->more_input) : [];
        return $goods;
    }

}
