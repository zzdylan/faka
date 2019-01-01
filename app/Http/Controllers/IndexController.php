<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class IndexController extends BaseController
{
    public function index(Request $request){
        $categories = Category::all();
        return view('home.index',compact('categories'));
    }
}
