<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;
use App\Models\Category;

class IndexController extends BaseController
{

    public function index(Request $request)
    {
        $param = http_build_query($request->all());
        return view('home.index',['param'=>$param]);
    }

    public function selectGoods(Request $request)
    {
        $data = [];
        $categories = Category::where('status',1)->orderBy('sort','asc')->get();
        if($request->goods_id && $currentGoods = Goods::find($request->goods_id)){
            $data['currentGoods'] = $currentGoods;
        }
        $data['categories'] = $categories;
        return view('home.selectGoods', $data);
    }

    public function queryOrders(){
        return view('home.queryOrders');
    }

}
