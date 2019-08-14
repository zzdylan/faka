<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{

    public function success($message='',$data=[]){
        return [
            'data' => $data,
            'message' => $message,
            'code' => 1
        ];
    }

    public function error($message=''){
        return [
            'message' => $message,
            'code' => 0
        ];
    }

}
