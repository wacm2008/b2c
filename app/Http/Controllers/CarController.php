<?php

namespace App\Http\Controllers;

use App\Model\CarModel;
use App\Model\GoodsModel;
use App\Model\SkuModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function carAdd(Request $request)
    {
        $buy_number=$request->input('buy_number');
        $goods_id=$request->input('goods_id');
        $shop_id=$request->input('shop_id');
        $goodsinfo=GoodsModel::where(['goods_id'=>$goods_id,'is_onsale'=>1,'is_delete'=>0])->first()->toArray();
        $skuinfo=SkuModel::where(['goods_id'=>$goods_id])->first()->toArray();
        if(empty($goods_id)){
            die('您还没有选择商品哦');
        }else if($goodsinfo['is_onsale']==0){
            die('您选的商品已下架哦');
        }else if($goodsinfo['is_delete']==1){
            die('您选的商品已被删除了哦');
        }
        if(empty($buy_number)){
            die('请选择商品数量哦');
        }
        $data=[
            'goods_id'=>$goods_id,
            'shop_id'=>$shop_id,
            'shop_name'=>$goodsinfo['shop_name'],
            'goods_name'=>$goodsinfo['goods_name'],
            'goods_img'=>$goodsinfo['goods_img'],
            'price'=>$goodsinfo['price'],
            'buy_number'=>$buy_number,
            'sku'=>$skuinfo['sku'],
            'car_status'=>1
        ];
        $res=CarModel::insert($data);
        if($res){
            echo json_encode(['msg'=>'添加成功','code'=>1]);
        }else{
            echo json_encode(['msg'=>'添加失败','code'=>2]);
        }
    }
    public function carlist()
    {
        $carInfo = DB::table('p_car')
            ->join('p_goods', 'p_car.goods_id', '=', 'p_goods.goods_id')
            ->select('p_car.*', 'p_goods.goods_name', 'p_goods.price','p_goods.goods_img','p_goods.store')
            ->get();
        return view('car/carlist',['carInfo'=>$carInfo]);
    }
    public function totalPrice(Request $request)
    {
        $goods_id=$request->input('goods_id');
        //print_r($goods_id);die;
        $goods_id=explode(',',$goods_id);
        //print_r($goods_id);die;
        foreach ($goods_id as $v){
            $info[]=CarModel::where(['goods_id'=>$v])->get()->toArray();
        }
        //print_r($info);die;
        $totalPrice=0;
        foreach($info as $k1=>$v1){
            foreach ($v1 as $key=>$value){
                $totalPrice+=$value['buy_number']*$value['price'];
            }
        }
        echo $totalPrice;
    }
    public function num()
    {
        $buy_number=request()->input('buy_number');
        $goods_id=request()->input('goods_id');
        $goodsInfo=GoodsModel::where('goods_id',$goods_id)->first()->toArray();
        if($goodsInfo) {
            $carWhere = [
                'goods_id' => $goods_id,
            ];
            $updateInfo = [
                'buy_number' => $buy_number
            ];
            $carInfoRes = CarModel::where($carWhere)->update($updateInfo);
        }
    }
}
