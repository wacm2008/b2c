<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarController extends Controller
{
    public function carAdd(Request $request)
    {
        $buy_number=$request->input('buy_number');
        $goods_id=$request->input('goods_id');
        echo $buy_number;echo '</br>';
        echo $goods_id;
    }
}
