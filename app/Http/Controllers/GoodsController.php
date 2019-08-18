<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\GoodsModel;
use App\Model\GoodsAttrModel;
use App\Model\GoodsAttrValueModel;
use App\Model\SkuModel;
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
        $store=SkuModel::select('store')->where(['goods_id'=>$goods_id])->first()->toArray();
        //print_r($store);die;
        $data=GoodsModel::where(['goods_id'=>$goods_id])->first()->toArray();
        //print_r($data);die;
        $attr = explode(',',$data['attr_id']);
        //print_r($attr);die;
        foreach ($attr as $k=>$v){
            $attr_info = GoodsAttrModel::select('attr_id','title')->where(['attr_id'=>$v])->get()->toArray();
            //print_r($attr_info);die;
            $attr_info1=[];
            foreach ($attr_info as $k1=>$v1){
                $attr_info1['attr_id']=$v1['attr_id'];
                $attr_info1['title']=$v1['title'];
            }
            //print_r($attr_info1);die;
            $attr_value[$attr_info1['attr_id']]['attr_name'] = $attr_info1['title'];
            $attr_value[$attr_info1['attr_id']]['attr_v'] = GoodsAttrValueModel::select('attr_vid','title')->where(['attr_id'=>$v])->get()->toArray();
        }
        //print_r($attr_value);die;
        $goodsdetail=[
            'goods_id'=>$goods_id,
            'goods_name'=>$data['goods_name'],
            'goods_img'=>$data['goods_img'],
            'price'=>$data['price'],
            'attr'=>$attr_value
        ];
        return view('goods/goodsdetail',$goodsdetail,$store);
    }
}
