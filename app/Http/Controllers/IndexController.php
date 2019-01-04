<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class IndexController extends BaseController
{

    public function index()
    {
        return view('home.index');
    }

    public function selectGoods(Request $request)
    {
        $categories = Category::orderBy('sort','asc')->get();
        return view('home.selectGoods', compact('categories'));
    }

    public function queryOrders(){
        return view('home.queryOrders');
    }

}
