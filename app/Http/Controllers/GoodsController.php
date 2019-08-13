<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\GoodsModel;
class GoodsController extends Controller
{
    public function index()
    {
        $data=GoodsModel::paginate(3);
        return view('goods/goodslist',['data'=>$data]);
    }
    public function goodsdetail($goods_id)
    {
        $goods_id=intval($goods_id);
        if(!$goods_id){
            return;
        }
    }
}
